<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use StatusResponser;


    public function updateProfile(Request $request)
    {
        $isPasswordUpdate = false;
        if ($request->current_password || $request->new_password || $request->new_password_confirmation) {
            $isPasswordUpdate = true;
        }
        if ($isPasswordUpdate) {
            $rules = [
                'current_password' => ['required', 'string', 'max:50'],
                'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
            ];
        }
        $rules['name'] = ['required'];
        $rules['email'] = ['required', 'unique:users,email,' . auth()->user()->id];
        $this->validate($request, $rules);
        if ($isPasswordUpdate) {
            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return $this->errorResponse("Old Password Doesn't match!");
            }
        }
        if ($isPasswordUpdate) {
            $user = User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password),
                'name' => $request->name,
                'email' => $request->email
            ]);
        } else {
            $user = User::whereId(auth()->user()->id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }

        if ($user) {
            return $this->successResponse(new UserResource(User::whereId(auth()->user()->id)->first()), 'Profile has been updated successfully.');
        }
        return $this->errorResponse();
    }
}
