<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmMail;
use App\Mail\ForgotEmail;
use App\Models\LoginLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        $data = [
            'page' => 'Halaman Login',
        ];
        return view('auth/login', $data);
    }
    public function register()
    {
        $data = [
            'page' => 'Halaman Daftar',
        ];
        return view('auth/register', $data);
    }
    public function reset_password()
    {
        $data = [
            'page' => 'Halaman Lupa Password',
        ];
        return view('auth/reset', $data);
    }
    public function admin_login()
    {
        $data = [
            'page' => 'Admin Login',
        ];
        return view('admin/auth/login', $data);
    }
    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                // 'g-recaptcha-response' => 'required|recaptchav3:login,0.5'
            ], [
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'password.required' => 'Password tidak boleh kosong',
                // 'g-recaptcha-response.required' => 'Captcha Tidak Valid',
            ]);

            $credentials = $request->only('email', 'password');
            $checkUser = User::where('email', $request->email)->first();
            if (!Auth::attempt($credentials, true)) throw new \ErrorException('Tidak dapat memverifikasi data anda');
            if ($checkUser->email_verify_status == 0) throw new \ErrorException('Akun anda belum diverifikasi, silahkan cek email anda untuk verifikasi akun');
            LoginLogs::create([
                'user_id' => Auth::user()->id,
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip()
            ]);
            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Login'
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'phone' => 'required|max:20',
                'email' => ['required', 'email:dns', 'unique:users'],
                'password' => ['required'],
            ]);
            $codeVerify = generateRandomString(15);
            $validatedData['password'] = Hash::make($validatedData['password']);
            $validatedData['balance'] = 0;
            $validatedData['role_id'] = 1;
            $validatedData['api_key'] = implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));
            $validatedData['email_verify_code'] = $codeVerify;

            //send email
            $mailInfo = new \stdClass();
            $mailInfo->to_name = $validatedData['name'];
            $mailInfo->to_email = $validatedData['email'];
            $mailInfo->verifyCode = $codeVerify;
            Mail::to($mailInfo->to_email)->send(new ConfirmMail($mailInfo));
            // end send email
            User::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mendaftarkan akun'
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function reset(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
            ]);
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $password = generateRandomString(12);

                // send email
                $mailData = new \stdClass();
                $mailData->to_email = $user->email;
                $mailData->to_name = $user->name;
                $mailData->password = $password;
                Mail::to($user->email)->send(new ForgotEmail($mailData));
                // end send email

                $user->password = Hash::make($password);
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil Mereset Password Akun'
                ]);
            } else {
                throw new \ErrorException('Tidak dapat mencari akun dari email anda');
            }
        } catch (\ErrorException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }
    public function activation($code)
    {
        $check = User::where('email_verify_code', $code)->first();
        if ($check) {
            $check->email_verify_status = 1;
            $check->save();
            return redirect('/auth/login')->with('success', 'Akun anda berhasil diaktivasi');
        }
        return redirect('/auth/login')->with('error', 'Akun anda tidak dapat diaktivasi');
    }
}
