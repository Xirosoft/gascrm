<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewDevPageController extends Controller
{
    public function index(Request $request) {
        $date = Carbon::today()->subDays(7);
        $newLeads = Lead::whereNull('is_converted')->where('created_at', '>=', $date)->where(function($q) {
            if (adminAccess(Auth::user()) === false) {
                $q->where('owner_id', Auth::user()->id);
            }
        })->count();
        
        $leadCounts = Lead::whereNull('is_converted')->where(function($q) {
            if (adminAccess(Auth::user()) === false) {
                $q->where('owner_id', Auth::user()->id);
            }
        })->count();
        
        $accountCounts = Account::where(function($q) {
            if (adminAccess(Auth::user()) === false) {
                $q->where('owner_id', Auth::user()->id);
            }
        })->count();
        
        $contactCounts = Contact::where(function($q) {
            if (adminAccess(Auth::user()) === false) {
                $q->where('owner_id', Auth::user()->id);
            }
        })->count();

        $tasks = Task::whereDate('created_at', Carbon::today())->where(function($q) {
            if (adminAccess(Auth::user()) === false) {
                $q->where('user_id', Auth::user()->id);
            }
        })->get();

        $events = Event::whereDate('created_at', Carbon::today())->where(function($q) {
            if (adminAccess(Auth::user()) === false) {
                $q->where('user_id', Auth::user()->id);
            }
        })->get();
        
        $sql = '';
        if (adminAccess(Auth::user()) === false) {
            $sql = "AND owner_id='".Auth::user()->id."'";
        }

        $leadStatus = LeadStatus::select('lead_statuses.name', 'A.counts')
        ->join(DB::raw("(SELECT lead_status_id, COUNT(id) AS counts FROM leads WHERE is_converted IS NULL AND deleted_at IS NULL $sql GROUP BY lead_status_id) AS A"), function($q) {
            $q->on('A.lead_status_id', '=', 'lead_statuses.id');
        })->get();




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



        return view('dashboard', compact('leadCounts', 'newLeads', 'accountCounts', 'contactCounts', 'leadStatus', 'tasks', 'events', 'records', 'leadStatus'))->with('list', 1);
    }
}
