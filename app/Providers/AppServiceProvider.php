namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- IMPORTANTE: Añade esta línea

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Si el entorno no es local (es decir, está en Render), fuerza HTTPS
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
