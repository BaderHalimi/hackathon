<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class FaqContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'الأسئلة الشائعة';

    protected static ?string $title = 'الأسئلة الشائعة';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?int $navigationSort = 70;

    protected static function sectionKey(): string
    {
        return 'faq';
    }
}
