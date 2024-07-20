<?php

namespace App\Filament\Guest\Resources\VentureResource\Pages;

use App\Filament\Guest\Resources\VentureResource;
use Filament\Resources\Pages\ListRecords;

class ListVentures extends ListRecords
{
  protected static ?string $slug = '/';

  protected static string $resource = VentureResource::class;
}
