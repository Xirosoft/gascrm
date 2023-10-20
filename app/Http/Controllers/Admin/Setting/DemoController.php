<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemoController extends Controller {

    public function index(Request $request)
    {
        $sql = Industry::orderBy('name', 'ASC');

        if ($request->q) {
            $sql->where('name', 'LIKE', $request->q.'%');
        }

        if ($request->status) {
            $sql->where('status', $request->status);
        }

        $users = $sql->paginate($request->limit ?? 15);

        return view('admin.setting.industry', compact('users'))->with('list', 1);
    }

    public function create()
    {
        return view('admin.setting.industry')->with('create', 1);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:industries,name',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $storeData = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        Industry::create($storeData);

        $request->session()->flash('successMessage', 'Industry was successfully added!');
        return redirect()->route('setting.industry.index', qArray());
    }

    public function show(Request $request, $id)
    {
        $data = Industry::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('setting.industry.index', qArray());
        }

        return view('admin.setting.industry', compact('data'))->with('show', $id);
    }

    public function edit(Request $request, $id)
    {
        $data = Industry::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('setting.industry.index', qArray());
        }

        return view('admin.setting.industry', compact('data'))->with('edit', $id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:industries,name',
            'status' => 'required|in:Active,Deactivated',
        ]);

        $data = Industry::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('setting.industry.index', qArray());
        }

        $storeData = [
            'name' => $request->name,
            'status' => $request->status,
        ];

        $data->update($storeData);

        $request->session()->flash('successMessage', 'Industry was successfully updated!');
        return redirect()->route('setting.industry.index', qArray());
    }

    public function destroy(Request $request, $id)
    {
        $data = Industry::find($id);
        if (empty($data)) {
            $request->session()->flash('errorMessage', 'Data not found!');
            return redirect()->route('setting.industry.index', qArray());
        }

        $data->delete();
        
        $request->session()->flash('successMessage', 'Industry was successfully deleted!');
        return redirect()->route('setting.industry.index', qArray());
    }
}
