<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lead;
use App\Models\Follow;
use App\Models\Account;
use App\Models\Contact;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list lead')) {
            return view('errors.403');
        }

        $sql = Lead::whereNull('is_converted')->orderBy('id', 'DESC');

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('salutation', 'LIKE', $request->q.'%')
                ->orWhere('first_name', 'LIKE', $request->q.'%')
                ->orWhere('last_name', 'LIKE', $request->q.'%')
                ->orWhere('company', 'LIKE', $request->q.'%')
                ->orWhere('mobile', 'LIKE', $request->q.'%')
                ->orWhere('email', 'LIKE', $request->q.'%')
                ->orWhere('title', 'LIKE', $request->q.'%');
            });
        }

        if ($request->status) {
            $sql->where('lead_status_id', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        $leadStatus = LeadStatus::where('status', 'Active')->orderBy('sort', 'ASC')->get();

        return view('admin.lead.index', compact('records', 'leadStatus'))->with('list', 1);
    }

    public function create(Request $request)
    {
        if (!Auth::user()->can('add lead')) {
            return view('errors.403');
        }

        return $this->index($request);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('lead_status_id', 'last_name', 'company'), [
            'lead_status_id' => 'required|numeric',
            'last_name' => 'required|max:255',
            'company' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'owner_id' => Auth::user()->id,
            'lead_status_id' => $request->lead_status_id,
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => trim($request->first_name.' '.$request->last_name),
            'company' => $request->company,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'website' => $request->website,
            'title' => $request->title,
            'rating_id' => $request->rating_id,
            'follow_up' => $request->follow_up,
            'address_street' => $request->address_street,
            'address_city' => $request->address_city,
            'address_state' => $request->address_state,
            'address_postalcode' => $request->address_postalcode,
            'address_country' => $request->address_country,
            'info_employees' => $request->info_employees,
            'info_revenue' => $request->info_revenue,
            'source_id' => $request->source_id,
            'industry_id' => $request->industry_id,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        Lead::create($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Lead was successfully added!'], 200);
    }

    public function show(Request $request, $id)
    {
        if (!Auth::user()->can('details lead')) {
            return view('errors.403');
        }

        $permissions = collect([
            'printLead' => Auth::user()->can('print lead'),
            'editLead' => Auth::user()->can('edit lead'),
            'deleteLead' => Auth::user()->can('delete lead'),
            'followLead' => Auth::user()->can('follow lead'),
            'convertLead' => Auth::user()->can('convert lead'),
            'change_ownerLead' => Auth::user()->can('change owner lead'),
            'change_statusLead' => Auth::user()->can('change status lead'),

            'addEmail' => Auth::user()->can('add email'),
            'addTask' => Auth::user()->can('add task'),
            'addEvent' => Auth::user()->can('add event'),
            'addNote' => Auth::user()->can('add note'),
            'addFile' => Auth::user()->can('add file'),
        ]);
        
        $sql = Lead::select('leads.*', 'follows.id AS is_following')
        ->leftJoin('follows', function($q) {
            $q->on('follows.followable_id', '=', 'leads.id');
            $q->where('follows.followable_type', '=', 'App\Models\Lead');
            $q->where('follows.user_id', '=', Auth::user()->id);
        })
        ->with(['owner', 'lead_status', 'rating', 'source', 'industry', 'creator', 'editor']);
        
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('lead.index', qArray());
        }

        return view('admin.lead.index', compact('permissions', 'data'))->with('show', $id);
    }

    public function printable(Request $request, $id)
    {
        if (!Auth::user()->can('print lead')) {
            return view('errors.403');
        }
        
        $sql = Lead::select('leads.*', 'follows.id AS is_following')
        ->leftJoin('follows', function($q) {
            $q->on('follows.followable_id', '=', 'leads.id');
            $q->where('follows.followable_type', '=', 'App\Models\Lead');
            $q->where('follows.user_id', '=', Auth::user()->id);
        })
        ->with(['owner', 'lead_status', 'rating', 'source', 'industry', 'creator', 'editor']);
        
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('lead.index', qArray());
        }

        return view('admin.lead.print', compact('data'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('lead_status_id', 'last_name', 'company'), [
            'lead_status_id' => 'required|numeric',
            'last_name' => 'required|max:255',
            'company' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Lead::where('id', $id);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            //'owner_id' => Auth::user()->id,
            'lead_status_id' => $request->lead_status_id,
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => trim($request->first_name.' '.$request->last_name),
            'company' => $request->company,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'website' => $request->website,
            'title' => $request->title,
            'rating_id' => $request->rating_id,
            'follow_up' => $request->follow_up,
            'address_street' => $request->address_street,
            'address_city' => $request->address_city,
            'address_state' => $request->address_state,
            'address_postalcode' => $request->address_postalcode,
            'address_country' => $request->address_country,
            'info_employees' => $request->info_employees,
            'info_revenue' => $request->info_revenue,
            'source_id' => $request->source_id,
            'industry_id' => $request->industry_id,
            'description' => $request->description,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Lead was successfully updated!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Lead::where('id', $id);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->first();
        
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'Lead was successfully deleted!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit lead')) {
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
            Lead::whereIn('id', $ids)->update([
                'status' => 'Active',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Deactivated') {
            Lead::whereIn('id', $ids)->update([
                'status' => 'Deactivated',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Delete') {
            Lead::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }

    public function follow(Request $request, $leadId)
    {
        if (!Auth::user()->can('follow lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Lead::where('id', $leadId);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->first();
        
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $follow = Follow::where('followable_id', $leadId)->where('followable_type', 'App\Models\Lead')->where('user_id', Auth::user()->id)->first();
        if (!empty($follow)) {
            $follow->delete();
            return response()->json(['status' => true, 'type' => 0, 'successMessage' => 'Lead was successfully unfollowed!'], 200);
        } else {
            Follow::create([
                'user_id' => Auth::user()->id,
                'followable_id' => $leadId,
                'followable_type' => 'App\Models\Lead',
            ]);
            return response()->json(['status' => true, 'type' => 1, 'successMessage' => 'Lead was successfully followed!'], 200);
        }
    }

    public function ownerChange(Request $request, $leadId)
    {
        if (!Auth::user()->can('change owner lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('owner_id'), [
            'owner_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Lead::where('id', $leadId);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }
        $data->update(['owner_id' => $request->owner_id]);

        return response()->json(['status' => true, 'owner' => $data->owner, 'successMessage' => 'Lead owner was successfully changed!'], 200);
    }

    public function convert(Request $request, $leadId)
    {
        if (!Auth::user()->can('convert lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('account', 'contact'), [
            'account' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Lead::where('id', $leadId);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->first();
        
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $accountData = [
            'owner_id' => $data->owner_id,
            'parent_id' => null,
            'name' => $request->account,
            'mobile' => $data->mobile,
            'fax' => null,
            'email' => $data->email,
            'website' => $data->website,
            'account_type_id' => null,
            'industry_id' => $data->industry_id,
            'info_employees' => $data->info_employees,
            'info_revenue' => $data->info_revenue,
            'description' => $data->description,
            'converted_lead_id' => $data->id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        Account::create($accountData);

        $contactData = [
            'owner_id' => $data->owner_id,
            'salutation' => null,
            'first_name' => null,
            'last_name' => $request->contact,
            'name' => trim($request->contact),
            'phone' => null,
            'mobile' => $data->mobile,
            'email' => $data->email,
            'account_id' => null,
            'title' => $data->title,
            'parent_id' => null,
            'fax' => null,
            'phone_home' => null,
            'phone_other' => null,
            'phone_assistant' => null,
            'assistant' => null,
            'department' => null,
            'source_id' => $data->source_id,
            'birth_date' => null,
            'description' => $data->description,
            'converted_lead_id' => $data->id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        Contact::create($contactData);

        $data->update(['is_converted' => 1]);        

        return response()->json(['status' => true, 'owner' => $data->owner, 'successMessage' => 'Lead was successfully coverted!'], 200);
    }

    public function statusChange(Request $request)
    {
        if (!Auth::user()->can('change status lead')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('lead_id'), [
            'lead_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Lead::where('id', $request->lead_id);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }

        $data = $sql->first();
        
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }
        if ($request->status_id > 0) {
            $data->update(['lead_status_id' => $request->status_id]);
        } else {
            $data->update(['is_completed' => 1]);
        }

        return response()->json(['status' => true, 'lead_status' => $data->lead_status, 'successMessage' => 'Lead status was successfully changed!'], 200);
    }
}
