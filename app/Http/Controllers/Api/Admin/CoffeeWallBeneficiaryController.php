<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoffeeWallBeneficiary;
use Illuminate\Http\Request;

class CoffeeWallBeneficiaryController extends Controller
{
    public function index()
    {
        $beneficiaries = CoffeeWallBeneficiary::all();
        return response()->json(['data' => $beneficiaries, 'status' => 'Success']);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $beneficiary = CoffeeWallBeneficiary::create(['name' => $request->name]);
        return response()->json(['data' => $beneficiary, 'status' => 'Success']);
    }

    public function show($id)
    {
        $beneficiary = CoffeeWallBeneficiary::findOrFail($id);
        return response()->json(['data' => $beneficiary, 'status' => 'Success']);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $beneficiary = CoffeeWallBeneficiary::findOrFail($id);
        $beneficiary->update(['name' => $request->name]);
        return response()->json(['data' => $beneficiary, 'status' => 'Success']);
    }

    public function destroy($id)
    {
        $beneficiary = CoffeeWallBeneficiary::findOrFail($id);
        $beneficiary->delete();
        return response()->json(['status' => 'Success']);
    }
}
