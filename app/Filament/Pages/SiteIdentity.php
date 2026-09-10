<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class SiteIdentity extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'الهوية والتنقل';

    protected static ?string $title = 'الهوية والتنقل';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?int $navigationSort = 10;

    protected static function sectionKey(): string
    {
        return 'identity';
    }
}
