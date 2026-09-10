<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class AboutContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'الشركاء وعن الهاكاثون';

    protected static ?string $title = 'الشركاء وعن الهاكاثون';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-information-circle';

    protected static ?int $navigationSort = 30;

    protected static function sectionKey(): string
    {
        return 'about';
    }
}
