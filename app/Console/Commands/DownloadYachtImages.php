<?php
//call php artisan yacht:download-images
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class DownloadYachtImages extends Command
{
    protected $signature = 'yachts:download-images {--batch=10} {--concurrent=2}';
    protected $description = 'Download yacht images, resize, convert to WebP, and organize by yacht ID.';

    private array $scales = [1400, 1200, 1000, 800, 600];

    public function handle()
    {
        // Získání celkového počtu obrázků, které nebyly zpracovány
        $totalImages = DB::table('api_yacht_images')->where('image_generated', 0)->count();
        $processedCount = 0;
        $batchSize = (int) $this->option('batch');
        $concurrentRequests = (int) $this->option('concurrent');

        $this->info("Processing $totalImages yacht images in batches of $batchSize with $concurrentRequests concurrent requests...");

        // Zpracování obrázků po dávkách
        DB::table('api_yacht_images')
            ->where('image_generated', 0) // Pouze obrázky, které nebyly zpracovány
            ->orderBy('id')
            ->chunkById($batchSize, function ($images) use ($totalImages, &$processedCount, $concurrentRequests) {
                $pendingImages = collect($images);

                while ($pendingImages->isNotEmpty()) {
                    $concurrentBatch = $pendingImages->take($concurrentRequests);
                    $pendingImages = $pendingImages->slice($concurrentRequests);

                    $concurrentBatch->each(function ($image) use (&$processedCount, $totalImages) {
                        try {
                            $this->processImage($image->yacht_id, $image->id, $image->url);

                            // Increment the processed count
                            $processedCount++;

                            // Calculate the percentage processed
                            $percentage = ($processedCount / $totalImages) * 100;
                            $this->info("Processed $processedCount of $totalImages images (" . round($percentage, 2) . "%)");

                            // Update image_generated to 1 after successful processing
                            DB::table('api_yacht_images')
                                ->where('id', $image->id)
                                ->update(['image_generated' => 1]);
                        } catch (\Exception $e) {
                            $this->error("Error processing image ID: $image->id - " . $e->getMessage());
                            $this->info('error!');
                            return; // Skip to the next iteration in case of error
                        }
                    });
                }
            });

        $this->info('Yacht images processing completed!');
        return 0;
    }

    private function processImage($yachtId, $imageId, $url)
    {
        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                $manager = new ImageManager(new Driver());
                $originalImage = $manager->read($response->body());
                $originalWidth = $originalImage->width();
                $originalHeight = $originalImage->height();
                $aspectRatio = $originalWidth / $originalHeight;

                foreach ($this->scales as $width) {
                    $height = intval($width / $aspectRatio);

                    // Změna velikosti se zachováním původního poměru stran
                    $scaledImage = $originalImage->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->toWebp(quality: 90);

                    $folderPath = "yacht_images/{$yachtId}";
                    $baseFilename = pathinfo($url, PATHINFO_FILENAME); // Get the base filename without extension

                    // Dekódování názvu souboru (např. %28 -> (, %29 -> ))
                    $baseFilename = urldecode($baseFilename);

                    // Normalizace názvu souboru (odstranění speciálních znaků)
                    $baseFilename = $this->normalizeFilename($baseFilename);

                    // Extract the part after the first underscore and append the new dimensions
                    if (strpos($baseFilename, '_') !== false) {
                        $baseFilename = substr($baseFilename, strpos($baseFilename, '_') + 1);
                    }

                    $filename = "{$baseFilename}_{$width}px.webp";
                    $path = "{$folderPath}/{$filename}";

                    Storage::disk('public')->put($path, $scaledImage->toString());
                }
            } else {
                $this->warn("Failed to download image ID: $imageId from $url");
                Log::info('Failed to download image ID:'. $imageId .'from'. $url);
            }
        } catch (\Exception $e) {
            $this->error("Error processing image ID: $imageId - " . $e->getMessage());
        }
    }

    /**
     * Normalizuje název souboru odstraněním speciálních znaků.
     *
     * @param string $filename
     * @return string
     */
    private function normalizeFilename(string $filename): string
    {
        // Odstranění závorek a dalších speciálních znaků
        $filename = str_replace(['(', ')', '[', ']', '{', '}', '%'], '', $filename);

        // Nahrazení mezer a dalších znaků podtržítkem
        $filename = preg_replace('/[^\w\-\.]/', '_', $filename);

        return $filename;
    }
}