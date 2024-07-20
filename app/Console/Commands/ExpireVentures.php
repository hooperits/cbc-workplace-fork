<?php

namespace App\Console\Commands;

use App\Mail\Member\VentureExpired;
use App\Models\Venture;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ExpireVentures extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:expire-ventures';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Marcar emprendimientos como vencido';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $expiration = now();
    Venture::query()
      ->where('expires_at', '<', $expiration)
      ->where('is_expired', 0)
      ->get()
      ->each(function ($venture) {
        $venture->is_expired = 1;
        $venture->save();
        Mail::to($venture->member)->send(new VentureExpired($venture));
      });
  }
}
