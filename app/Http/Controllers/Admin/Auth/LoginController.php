<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminLocationLog;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::guard('admin')->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        // Log successful login with location data if available
        $this->logSuccessfulLogin($request);

        return redirect()->intended(route('admin.dashboard'));
    }

    protected function logSuccessfulLogin(Request $request)
    {
        $adminId = Auth::guard('admin')->id();
        $latitude = $request->input('login_latitude');
        $longitude = $request->input('login_longitude');

        // Log admin login with location data
        AdminLocationLog::logAdminLogin($adminId, $request, $latitude, $longitude);
    }

    public function logLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'nullable|numeric',
            'timestamp' => 'required|date',
        ]);

        // Log location access attempt
        AdminLocationLog::logLocationAccess(
            $request,
            $request->input('latitude'),
            $request->input('longitude'),
            $request->input('accuracy')
        );

        return response()->json(['status' => 'success']);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // Forgot Password Methods
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        // Generate a password reset token
        $admin = Admin::where('email', $request->email)->first();
        $token = Str::random(64);

        // Store token in database (you'll need to create password_reset_tokens table)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Send email with reset link (implement mail sending later)
        // Mail::to($request->email)->send(new AdminPasswordResetMail($token));

        return back()->with('status', __('crm.reset_link_sent'));
    }

    public function showResetPasswordForm($token)
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors(['email' => __('crm.invalid_reset_token')]);
        }

        // Update password
        $admin = Admin::where('email', $request->email)->first();
        $admin->password = Hash::make($request->password);
        $admin->save();

        // Delete reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('status', __('crm.password_reset_success'));
    }
}