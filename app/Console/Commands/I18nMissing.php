<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class I18nMissing extends Command
{
    protected $signature = 'i18n:missing {locale}';
    protected $description = 'List translation strings that are used but missing in JSON translation file, with file locations, progress and report.';

    public function handle()
    {
        $locale = $this->argument('locale');
        $fs = new Filesystem();

        $jsonPath = base_path("lang/{$locale}.json");

        if (!$fs->exists($jsonPath)) {
            $this->error("File not found: {$jsonPath}");
            return 1;
        }

        $existing = json_decode($fs->get($jsonPath), true) ?: [];

        // Directories to scan
        $scanPaths = [
            base_path('app/Http'),
            base_path('resources/views'),
            base_path('resources/js'),
            base_path('routes'),
        ];

        $this->info("Scanning directories:");
        foreach ($scanPaths as $p) {
            $this->line(" - {$p}");
        }

        // build list of files to scan (only readable text files)
        $allFiles = [];
        foreach ($scanPaths as $path) {
            if (!$fs->exists($path)) continue;
            foreach ($fs->allFiles($path) as $file) {
                // skip binary-ish files by extension (quick heuristic)
                $ext = strtolower($file->getExtension());
                if (in_array($ext, ['png', 'jpg', 'jpeg', 'gif', 'zip', 'exe', 'phar', 'map', 'lock', 'bin'])) continue;
                $allFiles[] = $file->getPathname();
            }
        }

        $totalFiles = count($allFiles);
        if ($totalFiles === 0) {
            $this->warn("No files found to scan in configured paths.");
            return 0;
        }

        $this->info("Total files to scan: {$totalFiles}");
        $this->line('Starting scan...');

        // Regex to match __('...'), @lang('...'), trans('...'), trans_choice(...)
        // handles single/double quoted strings, escapes and multiline
        $regex = '/(?:__|@lang|trans|trans_choice)\(\s*(?:\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\'|"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)")/msu';

        $allStrings = []; // unique discovered strings => true
        $filesWithMatches = []; // filePath => [string => true]
        $stringLocations = []; // string => [ filePath, ... ]

        $progress = $this->output->createProgressBar($totalFiles);
        $progress->start();

        foreach ($allFiles as $filePath) {
            $progress->advance();

            try {
                $content = $fs->get($filePath);
            } catch (\Throwable $e) {
                // skip unreadable files
                continue;
            }

            if (preg_match_all($regex, $content, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    // m[1] => single quoted, m[2] => double quoted
                    $raw = isset($m[1]) && $m[1] !== '' ? $m[1] : (isset($m[2]) ? $m[2] : '');
                    if ($raw === '') continue;

                    // Unescape simple escapes (\' or \") to get the literal string
                    $raw = str_replace(["\\'", '\\"', '\\\\'], ["'", '"', "\\"], $raw);

                    // normalize: trim whitespace
                    $raw = trim($raw);

                    if ($raw === '') continue;
                    if (str_starts_with($raw, ':')) continue;

                    // Skip dotted PHP translation keys like 'common.name' OR 'auth.failed'
                    // BUT do not skip normal sentences containing dots/punctuation.
                    // Pattern: must be only word-like segments separated by dots (no spaces)
                    if (preg_match('/^[A-Za-z0-9\-_]+(\.[A-Za-z0-9\-_]+)+$/', $raw)) {
                        continue;
                    }

                    // collect
                    $allStrings[$raw] = true;
                    $filesWithMatches[$filePath][$raw] = true;

                    if (!isset($stringLocations[$raw])) {
                        $stringLocations[$raw] = [];
                    }
                    // avoid duplicate file entries
                    if (!in_array($filePath, $stringLocations[$raw], true)) {
                        $stringLocations[$raw][] = $filePath;
                    }
                }
            }
        }

        $progress->finish();
        $this->newLine(2);

        $scannedCount = $totalFiles;
        $foundFilesCount = count($filesWithMatches);
        $foundStringsCount = count($allStrings);

        $this->info("Scan finished. Files scanned: {$scannedCount}");
        $this->info("Files containing translation calls: {$foundFilesCount}");
        $this->info("Unique translation strings found: {$foundStringsCount}");

        // show short list of files with matches (clickable path shown)
        if ($foundFilesCount > 0) {
            $this->line("\nFiles with matches (first 50):");
            $i = 0;
            foreach ($filesWithMatches as $file => $matches) {
                $i++;
                $this->line(" {$i}. {$file}");
                if ($i >= 50) {
                    $this->line(" ...and more ({$foundFilesCount} total).");
                    break;
                }
            }
        } else {
            $this->warn("No translation function calls found in scanned files.");
        }

        // Determine missing keys and map to locations
        $missing = []; // list of missing strings
        $missingLocations = []; // string => [filePaths]

        foreach (array_keys($allStrings) as $str) {
            if (!array_key_exists($str, $existing)) {
                $missing[] = $str;
                $missingLocations[$str] = $stringLocations[$str] ?? [];
            }
        }

        $missingCount = count($missing);
        $this->line("");
        if ($missingCount === 0) {
            $this->info("All strings are translated for locale [{$locale}].");
        } else {
            $this->warn("Missing translations for locale [{$locale}]: ({$missingCount})");
            // list missing strings with file locations (limit output size)
            $limitStrings = 200;
            $stringIndex = 0;
            foreach ($missing as $miss) {
                $stringIndex++;
                $this->line(" {$stringIndex}. {$miss}");
                $locations = $missingLocations[$miss] ?? [];
                // show up to 8 file locations for each string to avoid flooding
                $locCount = count($locations);
                $showLoc = array_slice($locations, 0, 8);
                foreach ($showLoc as $loc) {
                    $this->line("     -> {$loc}");
                }
                if ($locCount > 8) {
                    $this->line("     -> ...and " . ($locCount - 8) . " more files");
                }
                if ($stringIndex >= $limitStrings) {
                    $this->line(" ...and more ({$missingCount} total).");
                    break;
                }
            }

            // Offer to add missing keys automatically to JSON
            if ($this->confirm('Add missing keys to JSON file? (they will be added with source text as value)', false)) {
                foreach ($missing as $miss) {
                    $existing[$miss] = $miss; // default: copy source text
                }
                ksort($existing);
                $fs->put($jsonPath, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $this->info("JSON updated: {$jsonPath}");
            }

            // Offer to write a report (detailed)
            if ($this->confirm('Save a detailed report of missing keys and source files to storage/logs? (recommended)', true)) {
                $reportPath = storage_path("logs/i18n-missing-{$locale}-" . date('Ymd_His') . ".log");
                $reportLines = [];
                $reportLines[] = "i18n missing report for locale: {$locale}";
                $reportLines[] = "generated_at: " . date('c');
                $reportLines[] = "";
                $reportLines[] = "scanned_paths:";
                foreach ($scanPaths as $p) {
                    $reportLines[] = " - {$p}";
                }
                $reportLines[] = "";
                $reportLines[] = "files_with_matches ({$foundFilesCount}):";
                foreach ($filesWithMatches as $file => $matches) {
                    $reportLines[] = " - {$file}";
                    foreach ($matches as $m => $_) {
                        $reportLines[] = "    * {$m}";
                    }
                }
                $reportLines[] = "";
                $reportLines[] = "missing_keys ({$missingCount}):";
                foreach ($missing as $m) {
                    $reportLines[] = " - {$m}";
                    $locs = $missingLocations[$m] ?? [];
                    foreach ($locs as $l) {
                        $reportLines[] = "     -> {$l}";
                    }
                }

                $fs->put($reportPath, implode(PHP_EOL, $reportLines));
                $this->info("Report saved: {$reportPath}");
                $this->line("Open the file path above in your editor/IDE to review.");
            }
        }

        return 0;
    }
}
