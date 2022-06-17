<?php

namespace App\Http\Controllers\Billar\User;

use App\Http\Controllers\Controller;
use App\Jobs\User\UserDeleted;
use App\Models\Core\Auth\User;
use App\Notifications\Core\User\UserNotification;
use App\Services\Billar\User\BillarUserService;
use Illuminate\Http\Request;

class BillarUserController extends Controller
{
    public function __construct(BillarUserService $service)
    {
        $this->service = $service;
    }

    public function userDelete(User $user)
    {
        $this->service
            ->setModel($user)
            ->beforeDelete()
            ->delete($user);



//        UserDeleted::dispatch((object)$user->toArray())
//            ->onConnection('sync');

        return deleted_responses('user');
    }
}
