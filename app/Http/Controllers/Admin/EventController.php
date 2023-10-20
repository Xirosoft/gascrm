<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list event')) {
            return view('errors.403');
        }

        $sql = Event::orderBy('id', 'DESC');

        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('subject', 'LIKE', $request->q.'%')
                ->orWhere('description', 'LIKE', $request->q.'%')
                ->orWhere('showtime_as', 'LIKE', $request->q.'%')
                ->orWhere('location', 'LIKE', $request->q.'%');
            });
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.event.index', compact('records'))->with('list', 1);
    }

    public function calender(Request $request)
    {
        if (!Auth::user()->can('calender event')) {
            return view('errors.403');
        }

        $records = [];

        return view('admin.event.calender', compact('records'))->with('list', 1);
    }

    public function calenderAjax(Request $request)
    {
        if (!Auth::user()->can('calender event')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Event::query();

        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }

        if ($request->start) {
            $sql->where('start_date', '>=', $request->start);
        }
        if ($request->end) {
            $sql->where('end_date', '>=', $request->end);
        }

        $records = $sql->get();
        return response()->json(['status' => true, 'records' => $records], 200);
    }

    public function create(Request $request)
    {
        if (!Auth::user()->can('add event')) {
            return view('errors.403');
        }

        return $this->index($request);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add event')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        // $validator = Validator::make($request->only('subject'), [
        //     'subject' => 'required|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        // }

        $conatctableType = null;
        if ($request->conatctable_id != null) {
            if ($request->actionable_type == 'Lead') {
                $conatctableType = "App\Models\Lead";
            } else {
                $conatctableType = "App\Models\Contact";
            }
        }

        $storeData = [
            'subject' => $request->subject,
            'description' => $request->description,
            'start_date' => $request->start_date ?? now(),
            'end_date' => $request->end_date ?? now()->addHour(),
            'location' => $request->location,
            'showtime_as' => $request->showtime_as,
            'account_id' => $request->account_id,
            'user_id' => $request->user_id,
            'conatctable_type' => $conatctableType,
            'conatctable_id' => $request->conatctable_id,
            'actionable_type' => $request->actionable_type != null ? "App\Models\\".$request->actionable_type : null,
            'actionable_id' => $request->actionable_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        Event::create($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Event was successfully created!'], 200);
    }

    public function show(Request $request, $id)
    {
        if (!Auth::user()->can('details event')) {
            return view('errors.403');
        }

        $permissions = collect([
            'editEvent' => Auth::user()->can('edit event'),
            'deleteEvent' => Auth::user()->can('delete event'),

            'addNote' => Auth::user()->can('add note'),
            'addFile' => Auth::user()->can('add file'),
        ]);
        
        $sql = Event::with(['user', 'account', 'conatctable', 'creator', 'editor']);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->find($id);
        
        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('event.index', qArray());
        }

        return view('admin.event.index', compact('permissions', 'data'))->with('show', $id);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit event')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        // $validator = Validator::make($request->only('subject'), [
        //     'subject' => 'required|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        // }

        $sql = Event::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            'subject' => $request->subject,
            'description' => $request->description,
            'start_date' => $request->start_date ?? now(),
            'end_date' => $request->end_date ?? now()->addHour(),
            'location' => $request->location,
            'showtime_as' => $request->showtime_as,
            'account_id' => $request->account_id,
            'user_id' => $request->user_id,
            'conatctable_type' => "App\Models\Contact",
            'conatctable_id' => $request->conatctable_id,
            'actionable_type' => null,
            'actionable_id' => null,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Event was successfully updated!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete event')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Event::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'Event was successfully deleted!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit event')) {
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

        if ($request->type == 'Delete') {
            Event::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }
}
