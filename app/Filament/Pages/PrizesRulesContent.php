<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class PrizesRulesContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'الجوائز والشروط';

    protected static ?string $title = 'الجوائز والشروط';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-trophy';

    protected static ?int $navigationSort = 60;

    protected static function sectionKey(): string
    {
        return 'prizes_rules';
    }
}
