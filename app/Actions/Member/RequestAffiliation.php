<?php

namespace App\Actions\Member;

use App\Enums\MembershipState;
use App\Mail\Member\AffilateRequest;
use App\Models\Config;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class RequestAffiliation
{
  use AsAction;

  public function handle(Member $member, array $data)
  {
    $member->membership_state = MembershipState::PENDING;
    $member->membership_reason = $data['reason'];
    $member->save();

    $member->addComment('Solicitud de Afiliación');

    $approvers = Config::make()->getp('approvers.affiliationRequests', []);
    foreach ($approvers as $approver) {
      $user = User::where('username', $approver)->first();
      if (! $user) {
        continue;
      }
      Mail::to($user)->send(new AffilateRequest($member));
    }
  }
}
