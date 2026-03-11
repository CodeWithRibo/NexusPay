<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Models\UserInformation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('Register');
    }

    public function register(AuthRequest $request)
    {
        $validated = $request->validated();

        if ($validated)
        {
            $birthDate = $request->birth_date;
            $getDate = $birthDate['year'].$birthDate['month'].$birthDate['day'];
            $generateDefPassword = $request->last_name.$getDate;

            $timestamp = Carbon::create($birthDate['year'],$birthDate['month'],$birthDate['day'])->format('Y-m-d');

             $user = User::query()
                ->create([
                    'student_id' => $request->role === 'student' ? $request->student_id : null,
                    'email' => $request->email,
                    'password' => $generateDefPassword,
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

    public function store(Request $request)
    {
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
