<?php

namespace App\Http\Controllers;

use App\Support\BrandAssets;
use App\Support\HomeContent;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SocialShareImageController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $identity = HomeContent::section('identity');
        $upload = trim((string) ($identity['share_image_path'] ?? ''));
        $image = $upload !== ''
            ? BrandAssets::info($upload, 'images/share-default.png')
            : BrandAssets::info('', 'images/share-default.png');

        return response()->file($image['path'], [
            'Content-Type' => $image['mime'],
            'Cache-Control' => 'public, max-age=604800, stale-while-revalidate=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
