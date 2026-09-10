<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class TimelineContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'الجدول الزمني';

    protected static ?string $title = 'الجدول الزمني';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 50;

    protected static function sectionKey(): string
    {
        return 'timeline';
    }
}
