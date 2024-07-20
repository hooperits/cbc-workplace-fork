<?php

namespace App\Actions\Admin;

use App\Mail\Member\VentureActiveToggled;
use App\Models\Venture;
use Illuminate\Support\Facades\Mail;
use Lorisleiva\Actions\Concerns\AsAction;

class VentureToggleActive
{
  use AsAction;

  public function handle(Venture $venture, array $data)
  {
    $venture->is_active = ! $venture->is_active;
    $venture->save();

    $state = ($venture->is_active) ? 'Activado' : 'Inactivado';
    $venture->addComment("Emprendimiento {$state}, Memo: {$data['reason']}");
    Mail::to($venture->member)->send(new VentureActiveToggled($venture));
  }
}
