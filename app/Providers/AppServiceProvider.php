<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Blade::directive('rupiah', function ($expression) {
      // Bisa dipakai dengan @rupiah($value) atau @rupiah($value, 2)
      $parts = explode(',', $expression);

      $value = trim($parts[0]); // nilai utama
      $decimal = $parts[1] ?? 0; // default 0 desimal

      return "<?php echo number_format($value, $decimal, ',', '.'); ?>";
    });
  }
}
