<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAccountController extends Controller
{
    use StatusResponser;

    public function __construct()
    {
        $this->middleware('password_confirm')->only('destroy');
    }


    public function index()
    {
        $admin_accounts = User::query();

        $admin_accounts = $this->whereClause($admin_accounts);
        $admin_accounts = $this->sortingAndLimit($admin_accounts);

        return $this->apiSuccessResponse(UserResource::collection($admin_accounts), 'Data Get Successfully!');
    }


    public function show(User $admin_account)
    {
        return $this->apiSuccessResponse(new UserResource($admin_account), 'Data Get Successfully!');
    }


    public function store(Request $request)
    {
        $validationRule = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        $admin_account = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($admin_account) {
            return $this->apiSuccessResponse(new UserResource($admin_account), 'Admin account has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function update(Request $request, User $admin_account)
    {
        $validationRule = [
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\User,email,' . $admin_account->id],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
        ];
        $this->validate(
            $request,
            $validationRule
        );

        $result = $admin_account->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($result) {
            return $this->apiSuccessResponse(new UserResource($admin_account), 'Admin account has been added successfully.');
        }
        return $this->errorResponse();
    }


    public function destroy(Request $request, User $admin_account)
    {
        if ($admin_account->delete()) {
            return $this->apiSuccessResponse(new UserResource($admin_account), 'Admin account has been deleted successfully.');
        }
        return $this->errorResponse();
    }

    protected function sortingAndLimit($admin_accounts)
    {
        if (isset($_GET['getAll']) && $_GET['getAll'] == '1') {
            return $admin_accounts->orderBy('name', 'asc')->get();
        }

        $sortType = ['ASC', 'asc', 'DESC', 'desc'];
        $sortBy = ['id', 'name', 'email'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $admin_accounts = $admin_accounts->OrderBy($_GET['sortBy'], $_GET['sortType']);
        }


        if (isset($_GET['limit']) && $_GET['limit'] != '') {
            $limit = $_GET['limit'];
        } else {
            $limit = 10;
        }

        return $admin_accounts->paginate($limit);
    }

    protected function whereClause($admin_accounts)
    {
        if (isset($_GET['searchParam']) && $_GET['searchParam'] != '') {
            $admin_accounts = $admin_accounts->where('name', 'LIKE', '%' . $_GET['searchParam'] . '%')->orWhere('email', 'LIKE', '%' . $_GET['searchParam'] . '%');
        }
        return $admin_accounts;
    }
}
