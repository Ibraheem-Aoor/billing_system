<?php

namespace App\Services\Billar\User;

use App\Exceptions\GeneralException;
use App\Models\Core\Auth\User;
use App\Notifications\Core\User\UserNotification;
use App\Services\Core\Auth\Traits\HasUserActions;
use App\Services\Core\BaseService;

class BillarUserService extends BaseService
{
    use HasUserActions;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function beforeNotification(User $user): User
    {
        notify()
            ->on('user_deleted')
            ->with((object)$user->toArray())
            ->send(UserNotification::class);

        return $user;
    }

    public function delete(User $user): self
    {
        if ($user->isAppAdmin() && !$user->isInvited())
            throw new GeneralException(trans('default.action_not_allowed'));

        if ($user->id == auth()->id())
            throw new GeneralException(trans('default.cant_delete_own_account'));

        $this->beforeNotification($user);
        $user->forceDelete();
        return $this;
    }
}