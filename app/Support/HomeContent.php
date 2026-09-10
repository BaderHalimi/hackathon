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
     * Plain lists (TagsInput) also tolerate a comma separated string, because a
     * value can be stored as a string from the admin panel and that would
     * otherwise break the page with "array_merge(): Argument #1 must be of type
     * array, string given".
     *
     * @param  array<string, mixed>  $defaults
     * @param  array<string, mixed>  $saved
     * @return array<string, mixed>
     */
    protected static function merge(array $defaults, array $saved): array
    {
        foreach ($saved as $key => $value) {
            $default = $defaults[$key] ?? null;

            // قائمة بسيطة (مثل TagsInput): تُقبل كنص مفصول بفواصل أيضًا
            if (static::isPlainList($default)) {
                $defaults[$key] = static::toPlainList($value, $default);

                continue;
            }

            // قائمة عناصرها مصفوفات (Repeater): تُستبدل كاملة حتى يُحترم الحذف والترتيب
            if (is_array($default) && is_array($value) && array_is_list($value)) {
                $defaults[$key] = $value;

                continue;
            }

            // إعدادات متداخلة: دمج مفتاح بمفتاح
            if (is_array($value) && is_array($default)) {
                $defaults[$key] = static::merge($default, $value);

                continue;
            }

            // شكل غير متوافق مع الافتراضي: نتجاهله ونُبقي القيمة الافتراضية
            if ($default !== null && is_array($default) !== is_array($value)) {
                continue;
            }

            $defaults[$key] = $value;
        }

        return $defaults;
    }

    /**
     * هل القيمة الافتراضية قائمة بسيطة (بدون عناصر مصفوفات)؟
     */
    protected static function isPlainList(mixed $default): bool
    {
        if (! is_array($default) || ! array_is_list($default)) {
            return false;
        }

        foreach ($default as $item) {
            if (is_array($item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * تحويل قيمة محفوظة إلى قائمة بسيطة (مصفوفة أو نص مفصول بفواصل).
     *
     * @param  array<int, mixed>  $default
     * @return array<int, mixed>
     */
    protected static function toPlainList(mixed $value, array $default): array
    {
        if (is_array($value)) {
            return array_values(array_filter($value, fn ($item) => ! is_array($item)));
        }

        if (is_string($value)) {
            $items = array_map('trim', explode(',', $value));

            return array_values(array_filter($items, fn ($item) => $item !== ''));
        }

        return $default;
    }
}
