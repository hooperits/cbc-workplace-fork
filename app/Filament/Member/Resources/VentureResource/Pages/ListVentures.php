<?php

namespace App\Filament\Member\Resources\VentureResource\Pages;

use App\Enums\MembershipState;
use App\Enums\VentureApprovalState;
use App\Filament\Member\Resources\VentureResource;
use App\Filament\Shared\Resources\BaseVentureResource\Pages\BaseListVentures;
use App\Helpers\Util;
use App\Models\Venture;
use Filament\Facades\Filament;
use Filament\Resources\Components\Tab;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListVentures extends BaseListVentures
{
  protected static string $resource = VentureResource::class;

  public function mount(): void
  {
    parent::mount();
    if (Filament::auth()->user()->membership_state !== MembershipState::APPROVED) {
      Util::filamentNotification(__('Usted debe afiliarse para poder publicar su emprendimientos'), 'warning');
      $this->redirect('/member/profile');
    }
  }

  public function getTabs(): array
  {
    return [
      __('models/venture.resource.tabs.undefined') => Tab::make()
        ->badge($this->getCountOfApprovalState(VentureApprovalState::UNDEFINED))
        ->modifyQueryUsing(fn (Builder $query) => $query->where('approval_state', VentureApprovalState::UNDEFINED)),
      __('models/venture.resource.tabs.pending') => Tab::make()
        ->badge($this->getCountOfApprovalState(VentureApprovalState::PENDING))
        ->modifyQueryUsing(fn (Builder $query) => $query->where('approval_state', VentureApprovalState::PENDING)),
      __('models/venture.resource.tabs.approved') => Tab::make()
        ->badge($this->getCountOfApprovalState(VentureApprovalState::APPROVED))
        ->modifyQueryUsing(fn (Builder $query) => $query->where('approval_state', VentureApprovalState::APPROVED)),
      __('models/venture.resource.tabs.rejected') => Tab::make()
        ->badge($this->getCountOfApprovalState(VentureApprovalState::REJECTED))
        ->modifyQueryUsing(fn (Builder $query) => $query->where('approval_state', VentureApprovalState::REJECTED)),
    ];
  }

  protected function getCountOfApprovalState(VentureApprovalState $state)
  {
    return Venture::ofMember(auth()->user())->where('approval_state', $state)->count();
  }

  public static function getNavigationLabel(): string
  {
    return __('Emprendimientos');
  }

  public static function getNavigationIcon(): string|Htmlable|null
  {
    return 'heroicon-o-light-bulb';
  }
}
