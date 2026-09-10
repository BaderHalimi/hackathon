<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * صور الهوية: الشعارات والأيقونات وصورة المشاركة.
 *
 * لكل شعار نسخة للوضع الفاتح ونسخة للوضع الداكن، ولو المطلوب غير موجود
 * نرجع للنسخة الثانية ثم للشعار المشترك ثم للملف الافتراضي في public.
 */
class BrandAssets
{
    /**
     * مسار الصورة المرفوعة المناسبة للوضع الحالي، أو فراغ إذا ما في صورة مرفوعة.
     *
     * @param  array<string, mixed>  $identity
     */
    public static function upload(array $identity, string $base, string $theme): string
    {
        $order = $theme === 'dark'
            ? ['_dark_path', '_light_path', '_path']
            : ['_light_path', '_dark_path', '_path'];

        foreach ($order as $suffix) {
            $value = trim((string) ($identity[$base.$suffix] ?? ''));

            if ($value !== '' && Storage::disk('public')->exists($value)) {
                return $value;
            }
        }

        return '';
    }

    /**
     * معلومات الصورة النهائية: رابط مطلق + الأبعاد + نوع الملف.
     *
     * الرابط يُبنى من اسم المضيف الحالي (مش APP_URL) حتى يشتغل على أي دومين،
     * ونضيف رقم إصدار على أساس وقت تعديل الملف حتى تتحدّث المعاينة على
     * واتساب لما تتغيّر الصورة.
     *
     * @return array{url: string, width: int, height: int, mime: string}
     */
    public static function info(string $uploaded, string $defaultRelative): array
    {
        $absolute = null;
        $url = null;

        if ($uploaded !== '') {
            $absolute = Storage::disk('public')->path($uploaded);
            $url = asset('storage/'.$uploaded);
        }

        if ($absolute === null || ! is_file($absolute)) {
            $absolute = public_path($defaultRelative);
            $url = asset($defaultRelative);
        }

        $size = @getimagesize($absolute) ?: [0, 0, null];
        $version = is_file($absolute) ? filemtime($absolute) : 0;

        return [
            'url' => $url.($version ? '?v='.$version : ''),
            'width' => (int) ($size[0] ?? 0),
            'height' => (int) ($size[1] ?? 0),
            'mime' => (string) ($size['mime'] ?? 'image/png'),
        ];
    }
}
