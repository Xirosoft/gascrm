<?php

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Contact;
use App\Models\Industry;
use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Rating;
use App\Models\Salutation;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// leads
Route::get('leads', function (Request $request) {
    // Fetch query parameters
    $leadStatus = $request->input('lead_status_id');
    $search = $request->input('search');
    $dateRange = $request->input('date_range');
    $perPage = $request->input('per_page', 20); // Default items per page
    $page = $request->input('page', 1);

    // Build the query
    $query = Lead::with(['lead_status', 'owner']); // Include relationships

    // Apply status filter if provided
    if (!empty($leadStatus)) {
        $query->where('lead_status_id', $leadStatus);
    }

    // Apply search filter if provided
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "{$search}%")
                ->orWhere('company', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Apply date range filter if provided
    if (!empty($dateRange) && is_array($dateRange) && count($dateRange) === 2) {
        $query->whereBetween('created_at', [$dateRange[0], $dateRange[1]]);
    }

    // Order by created_at in descending order
    $query->orderBy('created_at', 'desc');

    // Paginate the results
    $leads = $query->paginate($perPage, ['*'], 'page', $page);

    // Return as JSON response
    return response()->json($leads);
});
Route::get('leads/{id}', function ($id) {
    $lead = Lead::find($id);
    return response()->json($lead);
});


// leads
Route::get('accounts', function (Request $request) {
    // Fetch query parameters
    $type = $request->input('account_type_id');
    $search = $request->input('search');
    $dateRange = $request->input('date_range');
    $perPage = $request->input('per_page', 20); // Default items per page
    $page = $request->input('page', 1);

    // Build the query
    $query = Account::with(['owner', 'type']); // Include relationships

    if (!empty($type)) {
        $query->where('account_type_id', $type);
    }

    // Apply search filter if provided
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "{$search}%")
                ->orWhere('company', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Apply date range filter if provided
    if (!empty($dateRange) && is_array($dateRange) && count($dateRange) === 2) {
        $query->whereBetween('created_at', [$dateRange[0], $dateRange[1]]);
    }

    // Order by created_at in descending order
    $query->orderBy('created_at', 'desc');

    // Paginate the results
    $accounts = $query->paginate($perPage, ['*'], 'page', $page);

    // Return as JSON response
    return response()->json($accounts);
});
Route::get('accounts/{id}', function ($id) {
    $account = Account::find($id);
    return response()->json($account);
});

Route::get('contacts', function () {
    $contacts = Contact::all();
    return response()->json($contacts);
});

Route::get('tasks', function () {
    $tasks = Task::all();
    return response()->json($tasks);
});


Route::get('constants/{type}', function ($type) {
    switch ($type) {
        case 'salutation':
            $data = Salutation::all();
            break;
        case 'industry':
            $data = Industry::all();
            break;
        case 'lead-status':
            $data = LeadStatus::all();
            break;
        case 'rating':
            $data = Rating::all();
            break;
        case 'account-type':
            $data = AccountType::all();
            break;
        default:
            return response()->json(['error' => 'Invalid type specified'], 400);
    }

    return response()->json($data, 200);
});
;

Route::get('users', function (Request $request) {
    $query = User::query();

    // Add role filter
    if ($request->has('role') && $request->role) {
        $query->where('type', $request->role);
    }

    // Add status filter
    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }

    // Add search filter (search by name, email, or mobile)
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('mobile', 'like', '%' . $search . '%');
        });
    }

    // Add relationship counts for leads, accounts, and tasks
    $users = $query->withCount(['leads', 'accounts', 'tasks'])
        ->get()
        ->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'role' => $user->type,
                'status' => $user->status,
                'total_leads' => $user->leads_count,
                'total_accounts' => $user->accounts_count,
                'total_tasks' => $user->tasks_count,
                'created_by' => $user->created_by,
            ];
        });

    return response()->json($users, 200);
});


Route::get('users/{user}', function ($user) {
    $user = User::with([
        'tasks',
        'leads',
        'accounts',
        'contacts',
        'followings',
        'events',
        'notifications',
    ])->find($user);

    if ($user) {
        return response()->json($user, 200);
    }

    return response()->json(['error' => 'User not found'], 404);
});


Route::get('dashboard-stats', function () {
    $currentDate = Carbon::now();
    $startOfLastMonth = $currentDate->subMonth()->startOfMonth();
    $endOfLastMonth = $startOfLastMonth->endOfMonth();

    // Fetch data for the last month
    $lastMonthNewLeads = Lead::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
    $totalLeadsCount = Lead::count();
    $totalAccountsCount = Account::count();
    $totalContactsCount = Contact::count();

    // Calculate percentages
    $totalNewLeads = Lead::whereDate('created_at', now()->toDateString())->count();
    $newLeadsPercentage = $totalNewLeads > 0 ? round(($totalNewLeads / max($lastMonthNewLeads, 1)) * 100, 2) . '%' : '0%';

    $totalLeadsPercentage = $totalLeadsCount > 0 ? round(($totalLeadsCount / max($lastMonthNewLeads, 1)) * 100, 2) . '%' : '0%';
    $totalAccountsPercentage = $totalAccountsCount > 0 ? round(($totalAccountsCount / max($totalAccountsCount - 10, 1)) * 100, 2) . '%' : '0%';
    $totalContactsPercentage = $totalContactsCount > 0 ? round(($totalContactsCount / max($totalContactsCount - 15, 1)) * 100, 2) . '%' : '0%';

    // Generate last month's data for series
    $monthlyLeads = Lead::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
        ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
        ->groupBy('day')
        ->orderBy('day')
        ->pluck('count', 'day');

    $seriesData = [];
    for ($day = 1; $day <= $endOfLastMonth->day; $day++) {
        $seriesData[] = $monthlyLeads->get($day, 0); // Default to 0 if no data for the day
    }

    return response()->json([
        'newLeads' => [
            'label' => 'New Lead',
            'counter' => $totalNewLeads,
            'percentage' => $newLeadsPercentage,
            'series' => $seriesData,
        ],
        'totalLeads' => [
            'label' => 'Total Leads',
            'counter' => $totalLeadsCount,
            'percentage' => $totalLeadsPercentage,
            'series' => $seriesData,
        ],
        'totalAccounts' => [
            'label' => 'Total Accounts',
            'counter' => $totalAccountsCount,
            'percentage' => $totalAccountsPercentage,
            'series' => $seriesData,
        ],
        'totalContacts' => [
            'label' => 'Total Contacts',
            'counter' => $totalContactsCount,
            'percentage' => $totalContactsPercentage,
            'series' => $seriesData,
        ],
    ]);
});
