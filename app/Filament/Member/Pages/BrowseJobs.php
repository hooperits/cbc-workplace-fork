<?php

namespace App\Filament\Member\Pages;

use App\Enums\JobListingState;
use App\Models\JobListing;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BrowseJobs extends Page implements HasTable
{
  use InteractsWithTable;

  protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

  protected static string $view = 'filament.member.pages.browse-jobs';

  protected static ?int $navigationSort = 14;

  protected static bool $shouldRegisterNavigation = true;

  public static function getNavigationLabel(): string
  {
    return __('Buscar Empleo');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('navigation.busco-empleo');
  }

  public function getTitle(): string
  {
    return __('Buscar Empleo');
  }

  public function table(Table $table): Table
  {
    return $table
        ->query(
          JobListing::query()
              ->where('state', JobListingState::ACTIVE)
              ->whereHas('organization', function (Builder $query) {
                $query->excludingSuspended();
              })
        )
        ->columns([
          TextColumn::make('title')
              ->label(__('Título'))
              ->searchable()
              ->sortable()
              ->limit(40),
          TextColumn::make('organization.display_name')
              ->label(__('Organización'))
              ->searchable()
              ->limit(40),
          TextColumn::make('city')
              ->label(__('Ciudad'))
              ->sortable(),
          TextColumn::make('contract_type')
              ->label(__('Contrato')),
          TextColumn::make('work_modality')
              ->label(__('Modalidad')),
        ])
        ->actions([
          Action::make('view')
              ->label(__('Ver Detalle'))
              ->icon('heroicon-o-eye')
              ->url(fn (JobListing $record): string => url('/bolsa-de-trabajo/'.$record->slug)),
        ]);
  }

  public static function canAccess(): bool
  {
    $user = Filament::auth()->user();
    $hasOrganization = Organization::query()->where('member_id', auth('member')->id())->exists();
    return $user && $user->isMemberEnabled() && $hasOrganization;
  }
}
