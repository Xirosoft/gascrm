<?php

namespace App\Http\Controllers\Admin;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list note')) {
            return view('errors.403');
        }

        $sql = Note::with(['conatctable', 'actionable'])->orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->orWhere('subject', 'LIKE', $request->q.'%')
                ->orWhere('details', 'LIKE', $request->q.'%');
            });
        }

        if ($request->type) {
            $sql->where('actionable_type', 'App\Models\\'.$request->type);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.note', compact('records'))->with('list', 1);
    }

    public function all(Request $request)
    {
        $sql = Note::orderBy('id', 'DESC');
        if ($request->actionable_type) {
            $sql->where('actionable_type', "App\Models\\".$request->actionable_type);
            $sql->where('actionable_id', $request->actionable_id);
        }
        $records = $sql->get();

        return response()->json(['status' => true, 'records' => $records], 200);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add note')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('details'), [
            'details' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

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
            'details' => $request->details,
            'conatctable_type' => $conatctableType,
            'conatctable_id' => $request->conatctable_id,
            'actionable_type' => $request->actionable_type != null ? "App\Models\\".$request->actionable_type : null,
            'actionable_id' => $request->actionable_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        Note::create($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Note was successfully created!'], 200);
    }
}
