<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LoginPageSettingResource;
use App\Models\LoginPageSetting;
use App\Models\User;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginPageSettingController extends Controller
{
    use StatusResponser;

    public function show()
    {
        $loginPageSetting = LoginPageSetting::query();

        if (isset($_GET['withLoginPageSettingDetail']) && $_GET['withLoginPageSettingDetail'] == '1') {
            $loginPageSetting = $loginPageSetting->with('loginPageSettingDetail');
        }

        if (isset($_GET['findByPageId']) && $_GET['findByPageId'] != '') {
            $loginPageSetting = $loginPageSetting->wherePageId($_GET['findByPageId']);
        }

        $loginPageSetting = $loginPageSetting->firstOrFail();

        return $this->successResponse(new LoginPageSettingResource($loginPageSetting), 'Data get successfully.');
    }

    public function passwordVerification(Request $request)
    {
        $user = User::find(\Auth::id());
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        if (Hash::check($request->password, $user->password)) {
            return $this->successResponse('', 'Password Check successfully.');
        } else {
            return $this->errorResponse('Password is incorrect.');
        }
    }
}
