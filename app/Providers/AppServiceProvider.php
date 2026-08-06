<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $settings = SiteSetting::allAsArray();
        // always referenced views
        View::share('site', $settings);
        View::share('setting', SiteSetting::class);

        Blade::directive('rupiah', function ($expression) {
            return "<?php echo 'Rp ' . number_format((float) $expression, 0, ',', '.'); ?>";
        });

        Blade::directive('dateid', function ($expression) {
            return "<?php echo ($expression) ? \\Carbon\\Carbon::parse($expression)->translatedFormat('d F Y') : '-'; ?>";
        });
    }
}