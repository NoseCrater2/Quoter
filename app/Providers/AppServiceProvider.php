<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::directive('priceFormat', function ($money) {
            return "<?php echo number_format($money, 2); ?>";
        });
        Blade::directive('calculatemeters', function ($width,$height) {
            if($width < 1 && $height < 1){
                return 1;
            }else if($width < 1){
                return $height * 1;
            }elseif($height < 1){
                return $width * 1;
            }
            else{
                return $width * $height;
            }
        });
    }
}
