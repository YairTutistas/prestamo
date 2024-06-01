<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::directive('moneyformat', function ($expression) {
            $expression = str_replace(["\"", " "], "", $expression);
            @list($number, $locale, $currency) = explode(",", $expression);
            $number = $number ?? 0;
            $locale = $locale ?? "en_US";
            $currency = $currency ?? "USD";

            return 
            '<?php 
                $moneyformat = new NumberFormatter("'. $locale .'", NumberFormatter::CURRENCY);
                echo $moneyformat->formatCurrency('. $number .', "' .$currency .'");
            ?>';
        });
    }
}
