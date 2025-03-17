<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Api\{Base ,Country, WorldRegion, YachtImage, Company, Yacht, YachtLicense, YachtCrew, YachtProduct, Equipment, YachtDescription, YachtType, SailingArea, YachtEquipment, Shipyard, YachtExtra};

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Registring any application services.
     *
     * @return void
     */
    public function register()
    {
        // Explicitně registrujeme modely, pokud je používáte ručně
        $this->app->bind(Base::class, function () {
            return new Base;
        });

        $this->app->bind(Country::class, function () {
            return new Country;
        });

        $this->app->bind(WorldRegion::class, function () {
            return new WorldRegion;
        });

        $this->app->bind(YachtImage::class, function () {
            return new YachtImage;
        });

        $this->app->bind(Company::class, function () {
            return new Company;
        });

        // Pokračujte ve stejném duchu pro další modely...
        $this->app->bind(Yacht::class, function () {
            return new Yacht;
        });

        $this->app->bind(YachtLicense::class, function () {
            return new YachtLicense;
        });

        $this->app->bind(YachtCrew::class, function () {
            return new YachtCrew;
        });

        $this->app->bind(YachtProduct::class, function () {
            return new YachtProduct;
        });

        $this->app->bind(Equipment::class, function () {
            return new Equipment;
        });

        $this->app->bind(YachtDescription::class, function () {
            return new YachtDescription;
        });

        $this->app->bind(YachtType::class, function () {
            return new YachtType;
        });

        $this->app->bind(SailingArea::class, function () {
            return new SailingArea;
        });

        $this->app->bind(YachtEquipment::class, function () {
            return new YachtEquipment;
        });

        $this->app->bind(Shipyard::class, function () {
            return new Shipyard;
        });

        $this->app->bind(YachtExtra::class, function () {
            return new YachtExtra;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
