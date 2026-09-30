<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Pengaturan extends Page
{
    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedUser;

    protected static string|\UnitEnum|null $navigationGroup =
        'LAINNYA';

    protected static ?string $navigationLabel =
        'About';

    protected static ?string $title =
        'About Us';

    protected string $view =
        'filament.pages.pengaturan';
}