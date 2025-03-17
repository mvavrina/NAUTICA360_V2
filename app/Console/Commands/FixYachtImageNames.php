<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Api\YachtImage;
use Illuminate\Support\Facades\File;

class FixYachtImageNames extends Command
{
    protected $signature = 'fix:yacht-image-names';
    protected $description = 'Přejmenuje soubory obrázků tak, aby místo kódovaných znaků byly původní znaky.';

    // Seznam kódovaných znaků a jejich dekódovaných ekvivalentů
    protected $encodedCharacters = [
        '%28' => '(', // (
        '%29' => ')', // )
        '%25' => '%', // %
        '%20' => ' ', // mezera
        '%5B' => '[', // [
        '%5D' => ']', // ]
        '%7B' => '{', // {
        '%7D' => '}', // }
    ];

    public function handle()
    {
        // Získání všech záznamů, kde název souboru obsahuje speciální znaky
        $images = YachtImage::where('name', 'LIKE', '%(%') // Obsahuje '('
            ->orWhere('name', 'LIKE', '%)%') // Obsahuje ')'
            ->orWhere('name', 'LIKE', '%\\%%') // Obsahuje '%'
            ->orWhere('name', 'LIKE', '% %') // Obsahuje mezery
            ->orWhere('name', 'LIKE', '%[%') // Obsahuje '['
            ->orWhere('name', 'LIKE', '%]%') // Obsahuje ']'
            ->orWhere('name', 'LIKE', '%{%') // Obsahuje '{'
            ->orWhere('name', 'LIKE', '%}%') // Obsahuje '}'
            ->get();

        // Projdeme všechny nalezené záznamy
        foreach ($images as $image) {
            $yachtId = $image->yacht_id;
            $this->info("Zpracovávám složku pro yacht_id: {$yachtId}");

            // Cesta ke složce s obrázky pro dané yacht_id
            $yachtFolder = storage_path('app/public/yacht_images/' . $yachtId);

            // Pokud složka existuje, projdeme všechny soubory
            if (File::exists($yachtFolder)) {
                $files = File::files($yachtFolder);

                foreach ($files as $file) {
                    $filename = $file->getFilename();

                    // Pokud název souboru obsahuje kódované znaky, dekódujeme je
                    $decodedFilename = $this->decodeFilename($filename);

                    // Pokud se název změnil (obsahoval kódované znaky)
                    if ($decodedFilename !== $filename) {
                        // Stará a nová cesta k souboru
                        $oldPath = $yachtFolder . '/' . $filename;
                        $newPath = $yachtFolder . '/' . $decodedFilename;

                        // Přejmenování souboru
                        if (File::exists($oldPath)) {
                            File::move($oldPath, $newPath);
                            $this->info("Přejmenováno: {$filename} -> {$decodedFilename}");
                        } else {
                            $this->error("Soubor neexistuje: {$filename}");
                        }
                    }
                }
            } else {
                $this->error("Složka neexistuje: {$yachtFolder}");
            }
        }

        $this->info('Přejmenování souborů dokončeno.');
    }

    /**
     * Dekóduje název souboru (nahradí kódované znaky jejich původními ekvivalenty).
     *
     * @param string $filename
     * @return string
     */
    private function decodeFilename(string $filename): string
    {
        // Projdeme všechny kódované znaky a nahradíme je jejich dekódovanými ekvivalenty
        foreach ($this->encodedCharacters as $encoded => $decoded) {
            $filename = str_replace($encoded, $decoded, $filename);
        }

        return $filename;
    }
}