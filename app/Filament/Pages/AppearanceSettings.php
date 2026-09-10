<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class AppearanceSettings extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'المظهر والألوان';

    protected static ?string $title = 'المظهر والألوان';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-swatch';

    protected static ?int $navigationSort = 15;

    protected static function sectionKey(): string
    {
        return 'appearance';
    }
}
