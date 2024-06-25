<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Passport\Token;

class AccessTokenExpired
{
    use Dispatchable, SerializesModels;

    public $token;

    /**
     * Create a new event instance.
     *
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }
}
