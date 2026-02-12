<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{
     /**
     * Display registration page.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
      */
    public function show_register()
    {
        return view('auth.register');
    }

     /**
     * Display login page.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|View
      */
    public function show_login()
    {
        return view('auth.login');
    }

    /**
     * Handle account registration request
     *
     * @param RegisterRequest $req
     * @return RedirectResponse
     */
    public function register(RegisterRequest $req)
    {
        $user = User::create($req->validated());

        auth()->login($user);

        return $this->authenticated($req, $user);
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(!Auth::validate($credentials)):
            return redirect()->to('connexion')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    /**
     * Log out account user.
     *
     * @return Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect('connexion');
    }

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
