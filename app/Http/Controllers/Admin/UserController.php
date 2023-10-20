<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list user')) {
            return view('errors.403');
        }

        $sql = User::orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where('name', 'LIKE', $request->q.'%')
                ->orWhere('mobile', 'LIKE', $request->q.'%')
                ->orWhere('email', 'LIKE', $request->q.'%');
        }

        if ($request->type) {
            $sql->where('type', $request->type);
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.user', compact('records'))->with('list', 1);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add user')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('name', 'mobile', 'email', 'password', 'password_confirmation', 'type', 'status'), [
            'name' => 'required|max:100',
            'mobile' => 'required|unique:users,mobile',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|max:20|min:8|confirmed',
            'type' => 'required|in:Admin,Staff',
            'status' => 'required|in:Active,Deactivated',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'status' => $request->status,
            'email_signature' => $request->email_signature,
            'created_by' => Auth::user()->id,
        ];
        $user = User::create($storeData);

        $user->assignRole('Staff');
        
        return response()->json(['status' => true, 'successMessage' => 'User was successfully added!'], 200);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit user')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('name', 'mobile', 'email', 'type', 'status'), [
            'name' => 'required|max:100',
            'mobile' => 'required|unique:users,mobile,'.$id.',id',
            'email' => 'required|email|max:100|unique:users,email,'.$id.',id',
            'type' => 'required|in:Admin,Staff',
            'status' => 'required|in:Active,Deactivated',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $data = User::find($id);
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'type' => $request->type,
            'status' => $request->status,
            'email_signature' => $request->email_signature,
            'updated_by' => Auth::user()->id,
        ];

        if ($request->password != '') {
            $validator = Validator::make($request->only('password', 'password_confirmation'), [
                'password' => 'required|max:20|min:8|confirmed',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
            }

            $storeData['password'] = Hash::make($request->password);
        }

        $data->update($storeData);

        $data->assignRole('Staff');
        
        return response()->json(['status' => true, 'successMessage' => 'User was successfully updated!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit user')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('type', 'ids'), [
            'type' => 'required|max:100',
            'ids' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $ids = array_filter($request->ids);

        if ($request->type == 'Active') {
            User::whereIn('id', $ids)->update([
                'status' => 'Active',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Deactivated') {
            User::whereIn('id', $ids)->update([
                'status' => 'Deactivated',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Delete') {
            User::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete user')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $data = User::find($id);
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'User was successfully deleted!'], 200);
    }
}
