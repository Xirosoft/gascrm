<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Mail\TaskSend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list task')) {
            return view('errors.403');
        }

        $sql = Task::orderBy('id', 'DESC');

        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('subject', 'LIKE', $request->q.'%')
                ->orWhere('comment', 'LIKE', $request->q.'%')
                ->orWhere('priority', 'LIKE', $request->q.'%')
                ->orWhere('status', 'LIKE', $request->q.'%');
            });
        }

        if ($request->account) {
            $sql->where('account_id', $request->account);
        }

        $records = $sql->paginate($request->limit ?? 15);

        $searchRoute = route('task.index');

        return view('admin.task.index', compact('records', 'searchRoute'))->with('list', 1);
    }

    public function delegated(Request $request)
    {
        if (!Auth::user()->can('delegated task')) {
            return view('errors.403');
        }

        $sql = Task::orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('subject', 'LIKE', $request->q.'%')
                ->orWhere('comment', 'LIKE', $request->q.'%')
                ->orWhere('priority', 'LIKE', $request->q.'%')
                ->orWhere('status', 'LIKE', $request->q.'%');
            });
        }

        if ($request->account) {
            $sql->where('account_id', $request->account);
        }

        $sql->where('user_id', Auth::user()->id);

        $records = $sql->paginate($request->limit ?? 15);

        $searchRoute = route('task.delegated');

        return view('admin.task.index', compact('records', 'searchRoute'))->with('delegated', 1);
    }

    public function today(Request $request)
    {
        if (!Auth::user()->can('today task')) {
            return view('errors.403');
        }

        $sql = Task::orderBy('id', 'DESC');

        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('subject', 'LIKE', $request->q.'%')
                ->orWhere('comment', 'LIKE', $request->q.'%')
                ->orWhere('priority', 'LIKE', $request->q.'%')
                ->orWhere('status', 'LIKE', $request->q.'%');
            });
        }

        if ($request->account) {
            $sql->where('account_id', $request->account);
        }

        $sql->where('due_date', date('Y-m-d'));

        $records = $sql->paginate($request->limit ?? 15);

        $searchRoute = route('task.today');

        return view('admin.task.index', compact('records', 'searchRoute'))->with('today', 1);
    }

    public function create(Request $request)
    {
        if (!Auth::user()->can('add task')) {
            return view('errors.403');
        }

        return $this->index($request);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add task')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('subject'), [
            'subject' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'user_id' => $request->user_id,
            'lead_id' => $request->lead_id,
            'contact_id' => $request->contact_id,
            'account_id' => $request->account_id,
            'subject' => $request->subject,
            'comment' => $request->comment,
            'due_date' => $request->due_date,
            'reminder_at' => $request->reminder_at,
            'status' => $request->status,
            'priority' => $request->priority,
            'actionable_type' => $request->actionable_type != null ? "App\Models\\".$request->actionable_type : null,
            'actionable_id' => $request->actionable_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        $task = Task::create($storeData);

        if ($task && $task->user_id > 0) {
            Mail::to($task->user->email)->send(new TaskSend($task));
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Task was successfully added!'], 200);
    }

    public function show(Request $request, $id)
    {
        if (!Auth::user()->can('details task')) {
            return view('errors.403');
        }

        $permissions = collect([
            'editTask' => Auth::user()->can('edit task'),
            'deleteTask' => Auth::user()->can('delete task'),

            'addNote' => Auth::user()->can('add note'),
            'addFile' => Auth::user()->can('add file'),
        ]);
        
        $sql = Task::with(['user', 'account', 'contact', 'lead', 'creator', 'editor']);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->find($id);

        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('task.index', qArray());
        }

        return view('admin.task.index', compact('permissions', 'data'))->with('show', $id);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit task')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('subject'), [
            'subject' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Task::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            'user_id' => $request->user_id,
            'lead_id' => $request->lead_id,
            'contact_id' => $request->contact_id,
            'account_id' => $request->account_id,
            'subject' => $request->subject,
            'comment' => $request->comment,
            'due_date' => $request->due_date,
            'reminder_at' => $request->reminder_at,
            'status' => $request->status,
            'priority' => $request->priority,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Task was successfully updated!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete task')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $sql = Task::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'Task was successfully deleted!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit task')) {
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
            Task::whereIn('id', $ids)->update([
                'status' => 'Active',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Deactivated') {
            Task::whereIn('id', $ids)->update([
                'status' => 'Deactivated',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Delete') {
            Task::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }

    public function change(Request $request, $id)
    {
        if (!Auth::user()->can('edit task')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('field'), [
            'field' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $sql = Task::where('id', $id);
        if (adminAccess(Auth::user()) === false) {
            $sql->where('user_id', Auth::user()->id);
        }
        $data = $sql->first();

        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            $request->field => $request->value,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);
        
        return response()->json(['status' => true, 'data' => $data, 'successMessage' => 'Task was successfully updated!'], 200);
    }
}
