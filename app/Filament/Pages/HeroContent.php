<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class HeroContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'واجهة الصفحة';

    protected static ?string $title = 'واجهة الصفحة';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?int $navigationSort = 20;

    protected static function sectionKey(): string
    {
        return 'hero';
    }
}
