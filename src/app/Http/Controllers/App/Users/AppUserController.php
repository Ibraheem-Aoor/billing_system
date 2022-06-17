<?php


namespace App\Http\Controllers\App\Users;

use App\Http\Controllers\Core\Auth\User\UserController as BaseUserController;
use Illuminate\Database\Eloquent\Builder;

class AppUserController extends BaseUserController
{
    public function index()
    {
        $existing_users = request()->has('existing') ? explode(',', request()->existing) : [];
        return $this->service
            ->filters($this->filter)
            ->when(!count($existing_users), function (Builder $builder) {
                $builder->whereHas('status', function (Builder $builder) {
                    $builder->where('name', '!=', 'status_invited');
                });
            }, function (Builder $builder) use ($existing_users) {
                $builder->whereHas('status', function (Builder $builder) {
                    $builder->where('name', '!=', 'status_invited');
                })->with('roles:id,name,is_admin,is_default,type_id,alias', 'profilePicture')
                    ->where(function (Builder $builder) {
                        $builder->whereHas('roles', fn($query) => $query->whereNull('alias'))
                            ->orWhereDoesntHave('roles');
                    })
                    ->whereNotIn('id', array_merge($existing_users, [1]));
            })
            ->latest('id')
            ->get(['id', 'first_name', 'last_name', 'email']);
    }
}