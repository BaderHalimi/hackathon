<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class TracksContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'المسارات';

    protected static ?string $title = 'المسارات';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-command-line';

    protected static ?int $navigationSort = 40;

    protected static function sectionKey(): string
    {
        return 'tracks';
    }
}
