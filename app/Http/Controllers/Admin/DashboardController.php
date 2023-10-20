<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Task;
use App\Models\Event;
use App\Models\Account;
use App\Models\Contact;
use App\Models\LeadStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
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
        return view('admin.dashboard', compact('leadCounts', 'newLeads', 'accountCounts', 'contactCounts', 'leadStatus', 'tasks', 'events'));
    }
}
