<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\PaymentMethodsComposer;
use Illuminate\Support\Facades\Blade;
use App\Helpers\ArabicHelper;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\LogSentEmail;
use Laravel\Mcp\Facades\Mcp;
use App\Mcp\Servers\LaravelServer;

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
        // Register MCP Server
        Mcp::local('LaravelServer', LaravelServer::class);

        // Register view composer for payment methods
        View::composer([
            'frontend.layout',
            'frontend.client.layout',
            'frontend.partials.footer',
            'frontend.cart.index'
        ], PaymentMethodsComposer::class);

        // Share notifications with client layout
        View::composer('frontend.client.layout', function ($view) {
            if (auth('client')->check()) {
                $notifications = \App\Models\Notification::where('client_id', auth('client')->id())
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
                
                $unreadCount = \App\Models\Notification::where('client_id', auth('client')->id())
                    ->where('read', false)
                    ->count();
                
                $view->with([
                    'notifications' => $notifications,
                    'unreadNotificationsCount' => $unreadCount
                ]);
            }
        });

        // Share active campaigns with all frontend views
        View::composer('frontend.layout', function ($view) {
            $activeCampaigns = \App\Models\Campaign::active()
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('activeCampaigns', $activeCampaigns);
        });

        // Register Blade directive for Arabic text processing
        Blade::directive('arabic', function ($expression) {
            return "<?php echo \App\Helpers\ArabicHelper::fixArabicText($expression); ?>";
        });

        // Listen for sent emails and log them
        Event::listen(MessageSent::class, LogSentEmail::class);
    }
}
