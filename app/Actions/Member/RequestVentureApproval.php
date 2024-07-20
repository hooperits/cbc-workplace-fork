<?php

namespace App\Actions\Member;

use App\Enums\VentureApprovalState;
use App\Mail\Member\VentureApprovalRequest;
use App\Models\Config;
use App\Models\User;
use App\Models\Venture;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestVentureApproval
{
  use AsAction;

  public function handle(Venture $venture)
  {
    $venture->approval_state = VentureApprovalState::PENDING;
    $venture->save();

    $venture->addComment('Solicitud de aprobación de emprendimiento');

    $approvers = Config::make()->getp('approvers.ventureRequests', []);
    foreach ($approvers as $approver) {
      $user = User::where('username', $approver)->first();
      if (! $user) {
        continue;
      }
      Mail::to($user)->send(new VentureApprovalRequest($venture));
    }
  }
}
