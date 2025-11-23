<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class RouteListService
{
    public function getNamedRoutes()
    {
        return collect(Route::getRoutes())
            ->filter(function ($route) {
                $methods = $route->methods();
                return collect($methods)->every(fn($m) => in_array($m, ['GET', 'HEAD']))
                    && $route->getName();
            })
            ->map(fn($route) => [
                'lah' => json_encode($route),
                'name' => $route->getName(),
                'uri' => $route->uri(),
                'method' => implode('|', $route->methods()),
            ])
            ->values();
    }
}
