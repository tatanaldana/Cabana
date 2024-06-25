<?php

namespace App\Listeners;

use App\Events\AccessTokenExpired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Passport\Token;

class RevokeAccessToken implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param AccessTokenExpired $event
     * @return void
     */
    public function handle(AccessTokenExpired $event)
    {
        $event->token->revoke();
    }
}
