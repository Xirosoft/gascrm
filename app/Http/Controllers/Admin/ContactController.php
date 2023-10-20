<?php

namespace App\Http\Controllers\Admin;

use App\Models\Follow;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\ContactAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list contact')) {
            return view('errors.403');
        }

        $sql = Contact::select('contacts.*', 'mailing.street AS mailing_street', 'mailing.city AS mailing_city', 'mailing.state AS mailing_state', 'mailing.postalcode AS mailing_postalcode', 'mailing.country AS mailing_country', 'other.street AS other_street', 'other.city AS other_city', 'other.state AS other_state', 'other.postalcode AS other_postalcode', 'other.country AS other_country')
        ->leftJoin('contact_addresses AS mailing', function($q) {
            $q->on('mailing.contact_id', '=', 'contacts.id');
            $q->where('mailing.type', '=', 'Mailing');
        })
        ->leftJoin('contact_addresses AS other', function($q) {
            $q->on('other.contact_id', '=', 'contacts.id');
            $q->where('other.type', '=', 'Other');
        })
        ->orderBy('id', 'DESC');

        if (adminAccess(Auth::user()) === false) {
            $sql->where('contacts.owner_id', Auth::user()->id);
        }

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('salutation', 'LIKE', $request->q.'%')
                ->orWhere('first_name', 'LIKE', $request->q.'%')
                ->orWhere('last_name', 'LIKE', $request->q.'%')
                ->orWhere('phone', 'LIKE', $request->q.'%')
                ->orWhere('mobile', 'LIKE', $request->q.'%')
                ->orWhere('email', 'LIKE', $request->q.'%')
                ->orWhere('title', 'LIKE', $request->q.'%');
            });
        }

        if ($request->account) {
            $sql->where('account_id', $request->account);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.contact.index', compact('records'))->with('list', 1);
    }

    public function create(Request $request)
    {
        if (!Auth::user()->can('add contact')) {
            return view('errors.403');
        }

        return $this->index($request);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add contact')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('last_name', 'account_id'), [
            'last_name' => 'required|max:255',
            'account_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'owner_id' => Auth::user()->id,
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => trim($request->first_name.' '.$request->last_name),
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'account_id' => $request->account_id,
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'fax' => $request->fax,
            'phone_home' => $request->phone_home,
            'phone_other' => $request->phone_other,
            'phone_assistant' => $request->phone_assistant,
            'assistant' => $request->assistant,
            'department' => $request->department,
            'source_id' => $request->source_id,
            'birth_date' => $request->birth_date,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        $data = Contact::create($storeData);

        if ($data) {
            ContactAddress::create([
                'contact_id' => $data->id,
                'type' => 'Mailing',
                'street' => $request->mailing_street,
                'city' => $request->mailing_city,
                'state' => $request->mailing_state,
                'postalcode' => $request->mailing_postalcode,
                'country' => $request->mailing_country,
            ]);
            
            ContactAddress::create([
                'contact_id' => $data->id,
                'type' => 'Other',
                'street' => $request->other_street,
                'city' => $request->other_city,
                'state' => $request->other_state,
                'postalcode' => $request->other_postalcode,
                'country' => $request->other_country,
            ]);
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Contact was successfully added!'], 200);
    }

    public function show(Request $request, $id)
    {
        if (!Auth::user()->can('details contact')) {
            return view('errors.403');
        }

        $permissions = collect([
            'printContact' => Auth::user()->can('print contact'),
            'editContact' => Auth::user()->can('edit contact'),
            'deleteContact' => Auth::user()->can('delete contact'),
            'followContact' => Auth::user()->can('follow contact'),
            'change_ownerContact' => Auth::user()->can('change owner contact'),

            'addEmail' => Auth::user()->can('add email'),
            'addTask' => Auth::user()->can('add task'),
            'addEvent' => Auth::user()->can('add event'),
            'addNote' => Auth::user()->can('add note'),
            'addFile' => Auth::user()->can('add file'),
        ]);

        $sql = Contact::select('contacts.*', 'follows.id AS is_following', 'mailing.street AS mailing_street', 'mailing.city AS mailing_city', 'mailing.state AS mailing_state', 'mailing.postalcode AS mailing_postalcode', 'mailing.country AS mailing_country', 'other.street AS other_street', 'other.city AS other_city', 'other.state AS other_state', 'other.postalcode AS other_postalcode', 'other.country AS other_country')
        ->leftJoin('follows', function($q) {
            $q->on('follows.followable_id', '=', 'contacts.id');
            $q->where('follows.followable_type', '=', 'App\Models\Contact');
            $q->where('follows.user_id', '=', Auth::user()->id);
        })
        ->leftJoin('contact_addresses AS mailing', function($q) {
            $q->on('mailing.contact_id', '=', 'contacts.id');
            $q->where('mailing.type', '=', 'Mailing');
        })
        ->leftJoin('contact_addresses AS other', function($q) {
            $q->on('other.contact_id', '=', 'contacts.id');
            $q->where('other.type', '=', 'Other');
        })
        ->with(['owner', 'parent', 'account', 'source', 'creator', 'editor']);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('contacts.owner_id', Auth::user()->id);
        }

        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('contact.index', qArray());
        }

        return view('admin.contact.index', compact('permissions', 'data'))->with('show', $id);
    }

    public function printable(Request $request, $id)
    {
        if (!Auth::user()->can('print contact')) {
            return view('errors.403');
        }

        $sql = Contact::select('contacts.*', 'follows.id AS is_following', 'mailing.street AS mailing_street', 'mailing.city AS mailing_city', 'mailing.state AS mailing_state', 'mailing.postalcode AS mailing_postalcode', 'mailing.country AS mailing_country', 'other.street AS other_street', 'other.city AS other_city', 'other.state AS other_state', 'other.postalcode AS other_postalcode', 'other.country AS other_country')
        ->leftJoin('follows', function($q) {
            $q->on('follows.followable_id', '=', 'contacts.id');
            $q->where('follows.followable_type', '=', 'App\Models\Contact');
            $q->where('follows.user_id', '=', Auth::user()->id);
        })
        ->leftJoin('contact_addresses AS mailing', function($q) {
            $q->on('mailing.contact_id', '=', 'contacts.id');
            $q->where('mailing.type', '=', 'Mailing');
        })
        ->leftJoin('contact_addresses AS other', function($q) {
            $q->on('other.contact_id', '=', 'contacts.id');
            $q->where('other.type', '=', 'Other');
        })
        ->with(['owner', 'parent', 'account', 'source', 'creator', 'editor']);

        if (adminAccess(Auth::user()) === false) {
            $sql->where('contacts.owner_id', Auth::user()->id);
        }

        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('contact.index', qArray());
        }

        return view('admin.contact.print', compact('data'))->with('show', $id);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit contact')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('last_name', 'account_id'), [
            'last_name' => 'required|max:255',
            'account_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Contact::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            //'owner_id' => Auth::user()->id,
            'salutation' => $request->salutation,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => trim($request->first_name.' '.$request->last_name),
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'account_id' => $request->account_id,
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'fax' => $request->fax,
            'phone_home' => $request->phone_home,
            'phone_other' => $request->phone_other,
            'phone_assistant' => $request->phone_assistant,
            'assistant' => $request->assistant,
            'department' => $request->department,
            'source_id' => $request->source_id,
            'birth_date' => $request->birth_date,
            'description' => $request->description,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);

        ContactAddress::updateOrCreate(['contact_id' => $data->id, 'type' => 'Mailing'], [
            'contact_id' => $data->id,
            'type' => 'Mailing',
            'street' => $request->mailing_street,
            'city' => $request->mailing_city,
            'state' => $request->mailing_state,
            'postalcode' => $request->mailing_postalcode,
            'country' => $request->mailing_country,
        ]);
        
        ContactAddress::updateOrCreate(['contact_id' => $data->id, 'type' => 'Other'], [
            'contact_id' => $data->id,
            'type' => 'Other',
            'street' => $request->other_street,
            'city' => $request->other_city,
            'state' => $request->other_state,
            'postalcode' => $request->other_postalcode,
            'country' => $request->other_country,
        ]);
        
        return response()->json(['status' => true, 'successMessage' => 'Contact was successfully updated!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete contact')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Contact::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->addresses()->delete();
        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'Contact was successfully deleted!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit contact')) {
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
            Contact::whereIn('id', $ids)->update([
                'status' => 'Active',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Deactivated') {
            Contact::whereIn('id', $ids)->update([
                'status' => 'Deactivated',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Delete') {
            Contact::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }

    public function follow(Request $request, $contactId)
    {
        if (!Auth::user()->can('follow contact')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Contact::where('id', $contactId);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $follow = Follow::where('followable_id', $contactId)->where('followable_type', 'App\Models\Contact')->where('user_id', Auth::user()->id)->first();
        if (!empty($follow)) {
            $follow->delete();
            return response()->json(['status' => true, 'type' => 0, 'successMessage' => 'Contact was successfully unfollowed!'], 200);
        } else {
            Follow::create([
                'user_id' => Auth::user()->id,
                'followable_id' => $contactId,
                'followable_type' => 'App\Models\Contact',
            ]);
            return response()->json(['status' => true, 'type' => 1, 'successMessage' => 'Contact was successfully followed!'], 200);
        }
    }

    public function ownerChange(Request $request, $contactId)
    {
        if (!Auth::user()->can('change owner contact')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('owner_id'), [
            'owner_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Contact::where('id', $contactId);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('owner_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }
        $data->update(['owner_id' => $request->owner_id]);

        return response()->json(['status' => true, 'owner' => $data->owner, 'successMessage' => 'Contact owner was successfully changed!'], 200);
    }
}
