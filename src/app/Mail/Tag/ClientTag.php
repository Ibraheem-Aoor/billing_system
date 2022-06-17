<?php

namespace App\Mail\Tag;

use Illuminate\Support\Facades\URL;

class ClientTag extends Tag
{
    protected object $user;
    protected string $password;

    public function __construct($user, $password, $notifier = null, $receiver = null)
    {
        $this->user = $user;
        $this->password = $password;
        $this->notifier = $notifier;
        $this->receiver = $receiver;
    }

    function notification(): array
    {
        return array_merge([
            '{name}' => $this->user->full_name,
        ], $this->common());
    }

    public function credential(): array
    {
        return array_merge([
            '{action_by}' => optional($this->notifier)->full_name,
            '{receiver_name}' => optional($this->user)->full_name,
            '{resource_url}' => URL::to('/'),
            '{email}' => optional($this->user)->email,
            '{password}' => $this->password
        ], $this->appNameAndLogo());

    }

    public function invitationSubject(): array
    {
        return array_merge([
            '{action_by}' => optional($this->notifier)->full_name
        ], $this->appNameAndLogo());
    }
}