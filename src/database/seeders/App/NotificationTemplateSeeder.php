<?php

namespace Database\Seeders\App;

use App\Models\Core\Notification\NotificationTemplate;
use App\Models\Core\Setting\NotificationEvent;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        NotificationEvent::withoutGlobalScope('name')->get()->map(function (NotificationEvent $event) {
            if ($event->name != 'user_invitation' && $event->name != 'password_reset'
                && $event->name != 'client_credential' &&
                $event->name != 'invoice_sending_attachment' &&
                $event->name != 'invoice_payment_reminder') {
                [$name, $action] = explode('_', $event->name);
                $templates = [
                    'system' => '',
                    'subject' => '',
                    'content' => ''
                ];
                if (array_key_exists($event->name, $this->template())) {
                    $templates = $this->template()[$event->name];
                } elseif (array_key_exists($action, $this->template())) {
                    $templates = $this->template()[$action];
                }

                $mail = NotificationTemplate::query()->create([
                    'subject' => strtr($templates['subject'], [
                        '{resource}' => $name,
                        '{app_name}' => $event->type->alias == 'app' ? '{app_name}' : '{brand_name}'
                    ]),
                    'default_content' => strtr($templates['content'], [
                        '{resource}' => $name,
                        '{button_label}' => 'View ' . ucfirst($name)
                    ]),
                    'custom_content' => null,
                    'type' => 'mail'
                ]);

                $database = NotificationTemplate::create([
                    'subject' => null,
                    'default_content' => strtr($templates['system'], [
                        '{resource}' => $name
                    ]),
                    'custom_content' => null,
                    'type' => 'database'
                ]);

                $event->templates()->attach(
                    [$database->id, $mail->id]
                );

            } else if ($event->name == 'user_invitation') {
                $mail = NotificationTemplate::create([
                    'subject' => 'User invitation form {app_name}',
                    'default_content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>Hope this mail finds you well and healthy. We are informing you that you\'ve been invited to our application by {action_by}. It\'ll be a great opportunity to work with you.</p><br>
<p><a href="{invitation_url}" target="_blank" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; text-decoration: none; text-underline: none">Accept Invitation</a></p><br>

<p></p><p>Thanks &amp; Regards,
</p><p>{app_name}</p>',
                    'custom_content' => null,
                    'type' => 'mail'
                ]);

                $event->templates()->attach(
                    [$mail->id]
                );
            } else if ($event->name == 'password_reset') {
                $mail = NotificationTemplate::create([
                    'subject' => 'Password reset link provided by {app_name}',
                    'default_content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>Your request for reset password has been approved from {app_name}. Press the button below to reset the password.</p><br>
<p><a href="{reset_password_url}" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; text-decoration: none; text-underline: none" target="_blank">Reset password</a></p><br>

We are highly expecting you as soon as possible. Hope you\'ll join us.
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>',
                    'custom_content' => null,
                    'type' => 'mail'
                ]);

                $event->templates()->attach(
                    [$mail->id]
                );
            } else if ($event->name == 'client_credential') {
                $mail = NotificationTemplate::create([
                    'subject' => 'You have been invited to join {app_name} by {action_by}',
                    'default_content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hello {receiver_name}</span><br></p><p>Your Login credentials are given, <br> Email : {email} <br> Password : {password}  <br>
To set up your account, please use these credentials and go to the following link.
</p><br>
<p><a href="{resource_url}" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; text-decoration: none; text-underline: none" target="_blank">Go to your account</a></p><br>
<p>You can change your password from your account password settings.</p>

Hope you will find useful!
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>',
                    'custom_content' => null,
                    'type' => 'mail'
                ]);

                $event->templates()->attach(
                    [$mail->id]
                );
            } else if ($event->name == 'invoice_sending_attachment') {
                $mail = NotificationTemplate::create([
                    'subject' => 'Invoice {invoice_number} for due {date}',
                    'default_content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hello {receiver_name}</span><br></p><p>I hope you’re well!
<br>
Please see attached invoice {invoice_number}.<br>
Don’t hesitate to contact us if you have any questions.
</p>
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>',
                    'custom_content' => null,
                    'type' => 'mail'
                ]);

                $event->templates()->attach(
                    [$mail->id]
                );
            } else if ($event->name == 'invoice_payment_reminder') {
                $mail = NotificationTemplate::create([
                    'subject' => 'Payment reminder for invoice {invoice_number}',
                    'default_content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>We hope that you’re enjoying our service
<br>
We did want to quickly mention that we haven’t received payment from you yet.<br>
If you have any questions don’t hesitate to reply to this email.
</p>
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>',
                    'custom_content' => null,
                    'type' => 'mail'
                ]);

                $event->templates()->attach(
                    [$mail->id]
                );
            }

        });
        $this->enableForeignKeys();
    }

    public function template()
    {
        return [
            'user_joined' => [
                'system' => 'A new user has been joined in {app_name}',
                'subject' => 'A new user has been joined in {app_name}',
                'content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>It\'s a piece of good news that a new user {name} has been joined in our application invited by {action_by}. Hope you will enjoy his work and collaborations.</p><br>
<p><a href="{resource_url}" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; text-decoration: none; text-underline: none" target="_blank">View Resource</a></p><br>

<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>'
            ],
            'user_invited' => [
                'system' => '{name} has been invited by {action_by}.',
                'subject' => 'A new user has been invited in {app_name}',
                'content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>It\'s a piece of good news that a new user {name} has been invited in our application, invited by {action_by}.</p><br>
<p><a href="{resource_url}" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; text-decoration: none; text-underline: none" target="_blank">View Resource</a></p><br>
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>'
            ],
            'roles_created' => [
                'system' => 'A new {resource} named {name} has been created by {action_by}.',
                'subject' => 'A new {resource} has been created in {app_name}',
                'content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>It\'s a piece of good news that a new {resource} named {name} has been created in our application by {action_by}. Please have a look at that.</p><br>
<p><a href="{resource_url}" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; ; text-decoration: none; text-underline: none" target="_blank">{button_label}</a></p><br>
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>'
            ],
            'roles_updated' => [
                'system' => 'A {resource} named {name} has been updated by {action_by}.',
                'subject' => 'A {resource} has been updated in {app_name}',
                'content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>It\'s a piece of good news that a {resource} named {name} has been updated in our application by {action_by}. Please have a look at that.</p><br>
<p><a href="{resource_url}" style="background: #4466F2;color: white;padding: 9px;border-radius: 4px;cursor: pointer; text-decoration: none; text-underline: none" target="_blank">{button_label}</a></p><br>

<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>'
            ],
            'roles_deleted' => [
                'system' => 'A {resource} named {name} has been deleted by {action_by}.',
                'subject' => 'A {resource} has been deleted in {app_name}',
                'content' => '<p><img src="{app_logo}" style="height: 75px"></p>
<p>
</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>We are going to inform you that a {resource} named has been deleted from our application by {action_by}.</p>
<p></p><p>Thanks for being with us.
</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>'
            ],

//            'invoice_created' => [
//                'system' => 'Invoice {invoice_number} for due {date}',
//                'subject' => 'Invoice {invoice_number} for due {date}',
//                'content' => '<p><img src="{app_logo}" style="height: 75px"></p>
//<p>
//</p><p><span style="background-color: var(--form-control-bg) ; color: var(--default-font-color) ;">Hi {receiver_name}</span><br></p><p>I hope you’re well! <br> Please see attached invoice {number}<br>
//Don’t hesitate to contact us if you have any questions.
//</p><br>
//<p></p><p>Thanks for being with us.
//</p><p>Regards,</p><p>{app_name}</p><p></p><p></p>'
//            ],

        ];
    }

}
