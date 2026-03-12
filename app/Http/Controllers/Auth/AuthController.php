<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\UserInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showRegister()
    {
        return Inertia::render('Register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        if ($validated)
        {
            $birthDate = $request->birth_date;
            $dateString = "{$birthDate['year']}-{$birthDate['month']}-{$birthDate['day']}";
            $formattedDate = Carbon::parse($dateString)->format('Ymd');

            $timestamp = Carbon::create($birthDate['year'],$birthDate['month'],$birthDate['day'])->format('Y-m-d');

            $deffPass =  str_replace(' ', '', strtoupper($request->last_name)) . $formattedDate;

            $user = User::query()
                ->create([
                    'student_id' => $request->role === 'student' ? $request->student_id : null,
                    'email' => $request->email,
                    'password' => $deffPass,
                    'role' => $request->role,
                ]);
            UserInformation::query()
                ->create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'birth_date' => $timestamp,
                    'user_id' => $user->id,
                ]);
        }
        return to_route('home');
    }

    public function showLogin ()
    {
        return Inertia::render('Login');
    }

    public function login(LoginRequest $request) {
        $login = $request->input('login');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_id';

        if (Auth::guard('web')->attempt([$fieldType => $login, 'password' => $password])) {
            $request->session()->regenerate();

            return to_route('home');
        }
        return back()->withErrors([
            'login' => 'Invalid credentials',
        ]);

    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
