<?php

namespace App\Support;

use App\Models\HomeSection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class HomeContent
{
    /** @return array<string, mixed> */
    public static function section(string $section): array
    {
        $defaults = config("home-content.sections.{$section}.defaults", []);

        if (! Schema::hasTable('home_sections')) {
            return $defaults;
        }

        $saved = Cache::rememberForever("home-content.{$section}", fn () => HomeSection::query()->where('section', $section)->value('content') ?? []
        );

        return static::merge($defaults, $saved);
    }

    /** @return array<string, array<string, mixed>> */
    public static function all(): array
    {
        $content = [];

        foreach (array_keys(config('home-content.sections', [])) as $section) {
            $content[(string) $section] = static::section((string) $section);
        }

        return $content;
    }

    public static function get(string $key, mixed $fallback = null): mixed
    {
        [$section, $path] = array_pad(explode('.', $key, 2), 2, null);

        return $path ? Arr::get(static::section($section), $path, $fallback) : static::section($section);
    }

    /** @param array<string, mixed> $content */
    public static function save(string $section, array $content): void
    {
        HomeSection::query()->updateOrCreate(['section' => $section], ['content' => $content]);
        Cache::forget("home-content.{$section}");
    }

    /**
     * Merge associative settings while allowing repeaters/lists to be replaced
     * completely, so deleting or reordering an item in Filament is respected.
     *
     * @param  array<string, mixed>  $defaults
     * @param  array<string, mixed>  $saved
     * @return array<string, mixed>
     */
    protected static function merge(array $defaults, array $saved): array
    {
        foreach ($saved as $key => $value) {
            if (is_array($value) && is_array($defaults[$key] ?? null) && ! array_is_list($value)) {
                $defaults[$key] = static::merge($defaults[$key], $value);
            } else {
                $defaults[$key] = $value;
            }
        }

        return $defaults;
    }
}
