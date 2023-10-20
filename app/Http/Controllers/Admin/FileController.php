<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list file')) {
            return view('errors.403');
        }

        $sql = File::with(['actionable'])->orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->orWhere('name', 'LIKE', $request->q.'%');
            });
        }

        if ($request->type) {
            $sql->where('actionable_type', 'App\Models\\'.$request->type);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.file', compact('records'))->with('list', 1);
    }

    public function all(Request $request)
    {
        $sql = File::orderBy('id', 'DESC');
        if ($request->actionable_type) {
            $sql->where('actionable_type', "App\Models\\".$request->actionable_type);
            $sql->where('actionable_id', $request->actionable_id);
        }
        $records = $sql->get();

        return response()->json(['status' => true, 'records' => $records], 200);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add file')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('file'), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }
        
        $upload = (new MediaController())->anyUpload($request->file, 'files');
        if ($upload) {
            $storeData = [
                'name' => $upload['name'],
                'url' => $upload['url'],
                'ext' => $upload['ext'],
                'mime_type' => $upload['mime_type'],
                'size' => $upload['size'],
                'size_text' => sizeFormat($upload['size']),
                'actionable_type' => $request->actionable_type != null ? "App\Models\\".$request->actionable_type : null,
                'actionable_id' => $request->actionable_id,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
            ];
            File::create($storeData);
            
            return response()->json(['status' => true, 'successMessage' => 'File was successfully created!'], 200);
        }
        return response()->json(['status' => false, 'errorMessage' => 'File not uploaded.'], 200);
    }
}
