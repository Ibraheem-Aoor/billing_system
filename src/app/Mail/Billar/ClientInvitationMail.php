<?php

namespace App\Mail\Billar;

use App\Mail\Tag\ClientTag;
use App\Models\Core\Auth\User;
use App\Notifications\Core\Helper\NotificationTemplateHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientInvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected object $user;
    protected String $password;
    protected ?\Illuminate\Contracts\Auth\Authenticatable $auth;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->auth = auth()->user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ClientInvitationMail
    {
        $template = $this->template();
        $tag = new ClientTag($this->user, $this->password , $this->auth);
        return $this->view('notification.mail.user.template', [
            'template' => $template->parse(
                $tag->credential()
            )
        ])->subject($template->parseSubject(
            method_exists($tag, 'invitationSubject')
                ? $tag->invitationSubject() : ['{name}' => $this->user->full_name]
        ));
    }

    public function template(): \App\Models\Core\Notification\NotificationTemplate
    {
        return NotificationTemplateHelper::new()
            ->on('client_credential')
            ->mail();
    }
}
