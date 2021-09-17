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
        Blade::directive('calculatemeters', function ($data) {
            if($data[0] < 1 && $data[1] < 1){
                return 1;
            }else if($data[0] < 1){
                return $data[0] * 1;
            }elseif($data[1] < 1){
                return $data[1] * 1;
            }
            else{
                return $data[0] * $data[1];
            }
        });
    }
}
