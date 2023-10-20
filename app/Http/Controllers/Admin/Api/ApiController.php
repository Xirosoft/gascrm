<?php

namespace App\Http\Controllers\Admin\Api;

use App\Models\Lead;
use App\Models\User;
use App\Models\Rating;
use App\Models\Source;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Industry;
use App\Models\LeadStatus;
use App\Models\Salutation;
use App\Models\AccountType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller {

    public function options(Request $request)
    {
        if ($request->users) {
            $users = User::where('status', 'Active')->get();
        } else {
            $users = null;
        }
        
        if ($request->leadStatus) {
            $leadStatus = LeadStatus::where('status', 'Active')->orderBy('sort', 'ASC')->get();
        } else {
            $leadStatus = null;
        }
        
        if ($request->leads) {
            $leads = Lead::where('status', 'Active')->where(function($sql) {
                if (adminAccess(Auth::user()) === false) {
                    $sql->where('owner_id', Auth::user()->id);
                }
            })->get();
        } else {
            $leads = null;
        }
        
        if ($request->accounts) {
            $accounts = Account::where('status', 'Active')->where(function($sql) {
                if (adminAccess(Auth::user()) === false) {
                    $sql->where('owner_id', Auth::user()->id);
                }
            })->get();
        } else {
            $accounts = null;
        }
        
        if ($request->contacts) {
            $contacts = Contact::where('status', 'Active')->where(function($sql) {
                if (adminAccess(Auth::user()) === false) {
                    $sql->where('owner_id', Auth::user()->id);
                }
            })->get();
        } else {
            $contacts = null;
        }
        
        if ($request->salutations) {
            $salutations = Salutation::where('status', 'Active')->orderBy('sort', 'ASC')->get();
        } else {
            $salutations = null;
        }
        
        if ($request->ratings) {
            $ratings = Rating::where('status', 'Active')->orderBy('sort', 'ASC')->get();
        } else {
            $ratings = null;
        }
        
        if ($request->sources) {
            $sources = Source::where('status', 'Active')->orderBy('sort', 'ASC')->get();
        } else {
            $sources = null;
        }
        
        if ($request->industries) {
            $industries = Industry::where('status', 'Active')->orderBy('sort', 'ASC')->get();
        } else {
            $industries = null;
        }
        
        if ($request->accountTypes) {
            $accountTypes = AccountType::where('status', 'Active')->orderBy('sort', 'ASC')->get();
        } else {
            $accountTypes = null;
        }
        
        if ($request->taskStatus) {
            $taskStatus = taskStatus();
        } else {
            $taskStatus = null;
        }
        
        if ($request->taskPriority) {
            $taskPriority = taskPriority();
        } else {
            $taskPriority = null;
        }        
        
        return response()->json([
            'status' => true, 
            'users' => $users,
            'leadStatus' => $leadStatus,
            'leads' => $leads,
            'accounts' => $accounts,
            'contacts' => $contacts,
            'salutations' => $salutations,
            'ratings' => $ratings,
            'sources' => $sources,
            'industries' => $industries,
            'accountTypes' => $accountTypes,
            'taskStatus' => $taskStatus,
            'taskPriority' => $taskPriority,
        ], 200);
    }
}
