<?php

namespace App\Http\Controllers\Admin;

use App\Models\Follow;
use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Models\AccountAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list account')) {
            return view('errors.403');
        }

        $sql = Account::select('accounts.*', 'billing.street AS billing_street', 'billing.city AS billing_city', 'billing.state AS billing_state', 'billing.postalcode AS billing_postalcode', 'billing.country AS billing_country', 'shipping.street AS shipping_street', 'shipping.city AS shipping_city', 'shipping.state AS shipping_state', 'shipping.postalcode AS shipping_postalcode', 'shipping.country AS shipping_country')
        ->leftJoin('account_addresses AS billing', function($q) {
            $q->on('billing.account_id', '=', 'accounts.id');
            $q->where('billing.type', '=', 'Billing');
        })
        ->leftJoin('account_addresses AS shipping', function($q) {
            $q->on('shipping.account_id', '=', 'accounts.id');
            $q->where('shipping.type', '=', 'Shipping');
        })
        ->orderBy('id', 'DESC');

        if (adminAccess(Auth::user()) === false) {
            $sql->where('accounts.owner_id', Auth::user()->id);
        }

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('name', 'LIKE', $request->q.'%')
                ->orWhere('mobile', 'LIKE', $request->q.'%')
                ->orWhere('fax', 'LIKE', $request->q.'%')
                ->orWhere('email', 'LIKE', $request->q.'%')
                ->orWhere('website', 'LIKE', $request->q.'%')
                ->orWhere('description', 'LIKE', $request->q.'%');
            });
        }

        if ($request->type) {
            $sql->where('account_type_id', $request->type);
        }

        $records = $sql->paginate($request->limit ?? 15);

        $accountTypes = AccountType::where('status', 'Active')->orderBy('sort', 'ASC')->get();

        return view('admin.account.index', compact('records', 'accountTypes'))->with('list', 1);
    }

    public function create(Request $request)
    {
        if (!Auth::user()->can('add account')) {
            return view('errors.403');
        }

        return $this->index($request);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add account')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('name'), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'owner_id' => Auth::user()->id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'fax' => $request->fax,
            'email' => $request->email,
            'website' => $request->website,
            'account_type_id' => $request->account_type_id,
            'industry_id' => $request->industry_id,
            'info_employees' => $request->info_employees,
            'info_revenue' => $request->info_revenue,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        $data = Account::create($storeData);

        if ($data) {
            AccountAddress::create([
                'account_id' => $data->id,
                'type' => 'Billing',
                'street' => $request->billing_street,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'postalcode' => $request->billing_postalcode,
                'country' => $request->billing_country,
            ]);
            
            AccountAddress::create([
                'account_id' => $data->id,
                'type' => 'Shipping',
                'street' => $request->shipping_street,
                'city' => $request->shipping_city,
                'state' => $request->shipping_state,
                'postalcode' => $request->shipping_postalcode,
                'country' => $request->shipping_country,
            ]);
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Account was successfully added!'], 200);
    }

    public function show(Request $request, $id)
    {
        if (!Auth::user()->can('details account')) {
            return view('errors.403');
        }

        $permissions = collect([
            'printAccount' => Auth::user()->can('print account'),
            'editAccount' => Auth::user()->can('edit account'),
            'deleteAccount' => Auth::user()->can('delete account'),
            'followAccount' => Auth::user()->can('follow account'),
            'change_ownerAccount' => Auth::user()->can('change owner account'),

            'addEmail' => Auth::user()->can('add email'),
            'addTask' => Auth::user()->can('add task'),
            'addEvent' => Auth::user()->can('add event'),
            'addNote' => Auth::user()->can('add note'),
            'addFile' => Auth::user()->can('add file'),
        ]);
        
        $sql = Account::select('accounts.*', 'follows.id AS is_following', 'billing.street AS billing_street', 'billing.city AS billing_city', 'billing.state AS billing_state', 'billing.postalcode AS billing_postalcode', 'billing.country AS billing_country', 'shipping.street AS shipping_street', 'shipping.city AS shipping_city', 'shipping.state AS shipping_state', 'shipping.postalcode AS shipping_postalcode', 'shipping.country AS shipping_country')
        ->leftJoin('follows', function($q) {
            $q->on('follows.followable_id', '=', 'accounts.id');
            $q->where('follows.followable_type', '=', 'App\Models\Account');
            $q->where('follows.user_id', '=', Auth::user()->id);
        })
        ->leftJoin('account_addresses AS billing', function($q) {
            $q->on('billing.account_id', '=', 'accounts.id');
            $q->where('billing.type', '=', 'Billing');
        })
        ->leftJoin('account_addresses AS shipping', function($q) {
            $q->on('shipping.account_id', '=', 'accounts.id');
            $q->where('shipping.type', '=', 'Shipping');
        })
        ->with(['owner', 'parent', 'type', 'industry', 'creator', 'editor']);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('accounts.owner_id', Auth::user()->id);
        }

        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('account.index', qArray());
        }

        return view('admin.account.index', compact('permissions', 'data'))->with('show', $id);
    }

    public function printable(Request $request, $id)
    {
        if (!Auth::user()->can('print account')) {
            return view('errors.403');
        }
        
        $sql = Account::select('accounts.*', 'follows.id AS is_following', 'billing.street AS billing_street', 'billing.city AS billing_city', 'billing.state AS billing_state', 'billing.postalcode AS billing_postalcode', 'billing.country AS billing_country', 'shipping.street AS shipping_street', 'shipping.city AS shipping_city', 'shipping.state AS shipping_state', 'shipping.postalcode AS shipping_postalcode', 'shipping.country AS shipping_country')
        ->leftJoin('follows', function($q) {
            $q->on('follows.followable_id', '=', 'accounts.id');
            $q->where('follows.followable_type', '=', 'App\Models\Account');
            $q->where('follows.user_id', '=', Auth::user()->id);
        })
        ->leftJoin('account_addresses AS billing', function($q) {
            $q->on('billing.account_id', '=', 'accounts.id');
            $q->where('billing.type', '=', 'Billing');
        })
        ->leftJoin('account_addresses AS shipping', function($q) {
            $q->on('shipping.account_id', '=', 'accounts.id');
            $q->where('shipping.type', '=', 'Shipping');
        })
        ->with(['owner', 'parent', 'type', 'industry', 'creator', 'editor']);
        
        if (adminAccess(Auth::user()) === false) {
            $sql->where('accounts.owner_id', Auth::user()->id);
        }

        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('account.index', qArray());
        }

        return view('admin.account.print', compact('data'))->with('show', $id);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit account')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('name'), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Account::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            //'owner_id' => Auth::user()->id,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'fax' => $request->fax,
            'email' => $request->email,
            'website' => $request->website,
            'account_type_id' => $request->account_type_id,
            'industry_id' => $request->industry_id,
            'info_employees' => $request->info_employees,
            'info_revenue' => $request->info_revenue,
            'description' => $request->description,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);

        AccountAddress::updateOrCreate(['account_id' => $data->id, 'type' => 'Billing'], [
            'account_id' => $data->id,
            'type' => 'Billing',
            'street' => $request->billing_street,
            'city' => $request->billing_city,
            'state' => $request->billing_state,
            'postalcode' => $request->billing_postalcode,
            'country' => $request->billing_country,
        ]);
        
        AccountAddress::updateOrCreate(['account_id' => $data->id, 'type' => 'Shipping'], [
            'account_id' => $data->id,
            'type' => 'Shipping',
            'street' => $request->shipping_street,
            'city' => $request->shipping_city,
            'state' => $request->shipping_state,
            'postalcode' => $request->shipping_postalcode,
            'country' => $request->shipping_country,
        ]);
        
        return response()->json(['status' => true, 'successMessage' => 'Account was successfully updated!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete account')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Account::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();
        
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->addresses()->delete();
        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'Account was successfully deleted!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit account')) {
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
            Account::whereIn('id', $ids)->update([
                'status' => 'Active',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Deactivated') {
            Account::whereIn('id', $ids)->update([
                'status' => 'Deactivated',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Delete') {
            Account::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }

    public function follow(Request $request, $accountId)
    {
        if (!Auth::user()->can('follow account')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Account::where('id', $accountId);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();
        
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $follow = Follow::where('followable_id', $accountId)->where('followable_type', 'App\Models\Account')->where('user_id', Auth::user()->id)->first();
        if (!empty($follow)) {
            $follow->delete();
            return response()->json(['status' => true, 'type' => 0, 'successMessage' => 'Account was successfully unfollowed!'], 200);
        } else {
            Follow::create([
                'user_id' => Auth::user()->id,
                'followable_id' => $accountId,
                'followable_type' => 'App\Models\Account',
            ]);
            return response()->json(['status' => true, 'type' => 1, 'successMessage' => 'Account was successfully followed!'], 200);
        }
    }

    public function ownerChange(Request $request, $accountId)
    {
        if (!Auth::user()->can('change owner account')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('owner_id'), [
            'owner_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Account::where('id', $accountId);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }
        $data->update(['owner_id' => $request->owner_id]);

        return response()->json(['status' => true, 'owner' => $data->owner, 'successMessage' => 'Account owner was successfully changed!'], 200);
    }
}
