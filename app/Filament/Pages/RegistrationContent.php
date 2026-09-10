<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\EditsHomeSection;
use Filament\Pages\Page;

class RegistrationContent extends Page
{
    use EditsHomeSection;

    protected static ?string $navigationLabel = 'نموذج التسجيل';

    protected static ?string $title = 'نموذج التسجيل';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?int $navigationSort = 80;

    protected static function sectionKey(): string
    {
        return 'registration';
    }
}
