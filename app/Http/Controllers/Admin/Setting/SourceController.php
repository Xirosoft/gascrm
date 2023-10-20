<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\Source;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SourceController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list source')) {
            return view('errors.403');
        }

        $sql = Source::orderBy('sort', 'ASC');

        if ($request->q) {
            $sql->where('name', 'LIKE', $request->q.'%');
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.setting.source', compact('records'))->with('list', 1);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add source')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('name', 'status'), [
            'name' => 'required|max:255|unique:sources,name',
            'status' => 'required|in:Active,Deactivated',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'name' => $request->name,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ];
        Source::create($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Source was successfully added!'], 200);
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit source')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('name', 'status'), [
            'name' => 'required|max:255|unique:sources,name,'.$id.',id',
            'status' => 'required|in:Active,Deactivated',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $data = Source::find($id);
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $storeData = [
            'name' => $request->name,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ];

        $data->update($storeData);
        
        return response()->json(['status' => true, 'successMessage' => 'Source was successfully updated!'], 200);
    }

    public function bulkUpdate(Request $request)
    {
        if (!Auth::user()->can('edit source')) {
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
            Source::whereIn('id', $ids)->update([
                'status' => 'Active',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Deactivated') {
            Source::whereIn('id', $ids)->update([
                'status' => 'Deactivated',
                'updated_by' => Auth::user()->id,
            ]);
        } else if ($request->type == 'Delete') {
            Source::whereIn('id', $ids)->delete();
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Selected Data\'s was successfully '.$request->type.'!'], 200);
    }

    public function sortable(Request $request)
    {
        if (!Auth::user()->can('edit source')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $data = Source::get();
        foreach ($data as $val) {
            foreach ($request->order as $order) {
                if ($order['id'] == $val->id) {
                    $val->update([
                        'sort' => $order['position'],
                        'updated_by' => Auth::user()->id,
                    ]);
                }
            }
        }

        return response()->json(['status' => true, 'successMessage' => 'Sorting was successfully updated!'], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!Auth::user()->can('delete source')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $data = Source::find($id);
        if (empty($data)) {
            return response()->json(['status' => false, 'errorMessage' => 'Data not found!'], 401);
        }

        $data->delete();
        
        return response()->json(['status' => true, 'successMessage' => 'Source was successfully deleted!'], 200);
    }
}
