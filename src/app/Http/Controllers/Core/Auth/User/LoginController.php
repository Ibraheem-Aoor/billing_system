<?php

namespace App\Http\Controllers\Core\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\Auth\User\LoginRequest as Request;
use App\Services\Core\Auth\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }


//    public function show()
//    {
//        return view('auth.login');
//    }
	public function show()
	{
		
		return env('APP_INSTALLED') ? view('auth.login')
			: redirect('install');
	}
    

    /**
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        try {

            $this->service->login();
            $route = home_route();

            return route(
                $route['route_name'],
                $route['route_params']
            );
        }catch (\Exception $exception){
            return response()->json([
                'message' => $exception instanceof ModelNotFoundException ? trans('default.resource_not_found', ['resource' => trans('default.user')]) : $exception->getMessage()
            ], 400);
        }
    }

    public function logOut(): RedirectResponse
    {
        auth()->logout();
        session()->flush();

        return redirect()->route('users.login.index');
    }

}
