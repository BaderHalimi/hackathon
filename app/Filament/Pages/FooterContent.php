<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class FooterContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'التذييل';

    protected static ?string $title = 'التذييل';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?int $navigationSort = 90;

    protected static function sectionKey(): string
    {
        return 'footer';
    }
}
