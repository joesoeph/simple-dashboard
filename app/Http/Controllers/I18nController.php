<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class I18nController extends Controller
{
    public function langJs()
    {
        $locale = request('locale', App::getLocale());
        $cacheKey = "i18n_js_{$locale}";

        $js = Cache::rememberForever($cacheKey, function () use ($locale) {
            $base = base_path("lang/{$locale}");
            $translations = [];


            if (is_dir($base)) {
                foreach (File::files($base) as $file) {
                    $name = pathinfo($file, PATHINFO_FILENAME); // menu, dashboard, etc
                    $ext = pathinfo($file, PATHINFO_EXTENSION);

                    if ($ext === 'php') {
                        // load PHP array safely
                        $array = include $file->getPathname();
                        if (is_array($array)) {
                            $translations[$name] = $array;
                        } else {
                            $translations[$name] = [];
                        }
                    } elseif ($ext === 'json') {
                        $json = json_decode(File::get($file->getPathname()), true);
                        $translations[$name] = $json ?: [];
                    } else {
                        // ignore other file types
                    }
                }
            }

            $rootJson = base_path("lang/{$locale}.json");
            if (File::exists($rootJson)) {
                $translations['__json'] = json_decode(File::get($rootJson), true) ?: [];
            }

            $payload = json_encode($translations, JSON_UNESCAPED_UNICODE);
            return "window.i18n = {$payload}; window.i18n_locale = '{$locale}';";
        });

        return response($js, 200)->header('Content-Type', 'application/javascript');
    }
}
