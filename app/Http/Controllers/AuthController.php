<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('pages.home')->with('success', 'Bạn đã đăng nhập trước đó');
        }

        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login.email' => 'required|email',
            'login.password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials['login'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->hasRole('user')) {
                return redirect()->route('pages.home')->with('success', 'Đăng nhập thành công');
            }

            Auth::logout();
        }

        throw ValidationException::withMessages([
            'login.email' => 'Thông tin đăng nhập không chính xác'
        ]);
    }

    public function logout()
    {
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Bạn chưa đăng nhập không thể đăng xuất');
        }

        Auth::logout();

        return redirect()->route('login.form')->with('success', 'Đăng xuất thành công');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            if (!$googleUser->getEmail()) {
                return redirect('/login')->with(['error' => 'Tài khoản Google của bạn không cung cấp email.']);
            }

            DB::beginTransaction();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'google_id' => $googleUser->getId(),
                    'password' => null,
                ]
            );

            Customer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $googleUser->getName(),
                    'img' => $googleUser->getAvatar(),
                ]
            );

            if ($user->wasRecentlyCreated) {
                $user->update(['role_id' => 2]);

                dispatch(new SendEmailFirstLoginWithGoogleJob($user));
            }

            DB::commit();

            Auth::login($user);

            return redirect()->route('home')->with('success', 'Đăng nhập thành công');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Google Login Error', ['message' => $e->getMessage()]);
            return redirect()->route('home')->with(['error' => 'Đăng nhập bằng Google thất bại.']);
        }
    }
}
