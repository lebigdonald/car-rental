<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLogingRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Models\Admin;

class AdminAuthController extends Controller
{

    /**
     * Display registration page.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|View
     */
    public function show_register()
    {
        return view('admin.auth.register');
    }

     /**
     * Display login page.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
      */
    public function show_login()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle account registration request
     *
     * @param AdminRegisterRequest $req
     * @return RedirectResponse
     */
    public function register(AdminRegisterRequest $req)
    {
        $admin = Admin::create($req->validated());

        auth()->login($admin);

        return $this->authenticated($req, $admin);
    }

    /**
     * Handle account login request
     *
     * @param AdminLogingRequest $request
     *
     * @return RedirectResponse
     */
    public function login(AdminLogingRequest $request)
    {

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->route('admin.login.show')
            ->withErrors(trans('auth.failed'));
        }
    }

    /**
     * Log out account user.
     *
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->flush();
        return redirect()->route('admin.login.show');
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
        return redirect()->route('admin.home');
    }
}
