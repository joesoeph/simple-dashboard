<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menus = Menu::with(['children' => function ($q) {
                $q->where('is_active', true);
            }])
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('order')
                ->get();

            $view->with('menus', $menus);
        });
    }
}
