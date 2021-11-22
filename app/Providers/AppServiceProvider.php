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
            $arrayWidhtHeight = explode (",", $data); //Separa cadenas por un delimitador y los guarda en un array
            if(floatval($arrayWidhtHeight[0]) < 1 && floatval($arrayWidhtHeight[1]) < 1){
                // return 1;
                // return number_format((floatval($data[0]) * 1), 3, '.', '');
                // return 1;
                return 1;
            }else if(floatval($arrayWidhtHeight[0]) < 1){
                // return $data[0] * 1;
                // return number_format((floatval($data[0]) * 1) * floatval($data[1]), 3, '.', '');
                // return ($data[0] * 1) * $data[1];
                return number_format((floatval(1) * floatval($arrayWidhtHeight[1])), 3, '.', '');
            }elseif(floatval($arrayWidhtHeight[1]) < 1){
                // return $data[1] * 1;
                // return number_format((floatval($data[1]) * 1) * floatval($data[0]), 3, '.', '');
                // return ($data[1] * 1) * $data[0];
                return number_format((floatval(1) * floatval($arrayWidhtHeight[0])), 3, '.', '');
            }
            else{
                // return $data[0] * $data[1];
                // return number_format(floatval($data[0]) * floatval($data[1]), 3, '.', '');
                // return $data[0] * $data[1];
                return number_format(floatval($arrayWidhtHeight[0]) * floatval($arrayWidhtHeight[1]), 3, '.', '');
            }
        });
    }
}
