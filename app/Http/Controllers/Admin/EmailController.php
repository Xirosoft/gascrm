<?php

namespace App\Http\Controllers\Admin;

use App\Models\Email;
use App\Mail\EmailSend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller {

    public function index(Request $request)
    {
        if (!Auth::user()->can('list email')) {
            return view('errors.403');
        }

        $sql = Email::with(['account', 'actionable'])->orderBy('id', 'DESC');

        if ($request->q) {
            $sql->where(function($q) use($request) {
                $q->where('from', 'LIKE', $request->q.'%')
                ->orWhere('to', 'LIKE', $request->q.'%')
                ->orWhere('cc', 'LIKE', $request->q.'%')
                ->orWhere('bcc', 'LIKE', $request->q.'%')
                ->orWhere('subject', 'LIKE', $request->q.'%')
                ->orWhere('message', 'LIKE', $request->q.'%');
            });
        }

        if ($request->type) {
            $sql->where('actionable_type', 'App\Models\\'.$request->type);
        }

        $records = $sql->paginate($request->limit ?? 15);

        return view('admin.email', compact('records'))->with('list', 1);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('add email')) {
            return response()->json(['status' => false, 'errorMessage' => 'Unauthorized Access!'], 401);
        }

        $validator = Validator::make($request->only('to', 'subject', 'message'), [
            'to' => 'required|array|min:1',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errorMessage' => implode(", " , $validator->messages()->all())], 200);
        }

        $storeData = [
            'from' => $request->from,
            'to' => json_encode($request->to),
            'cc' => $request->cc != null ? json_encode($request->cc) : null,
            'bcc' => $request->bcc != null ? json_encode($request->bcc) : null,
            'subject' => $request->subject,
            'message' => $request->message,
            'account_id' => $request->account_id,
            'actionable_type' => $request->actionable_type != null ? "App\Models\\".$request->actionable_type : null,
            'actionable_id' => $request->actionable_id,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ];
        $email = Email::create($storeData);
        if ($email) {
            $m =  Mail::to($request->to);
            if ($request->cc != null) {
                $m->cc($request->cc);
            }
            if ($request->bcc != null) {
                $m->bcc($request->bcc);
            }
            $m->send(new EmailSend($email));
        }
        
        return response()->json(['status' => true, 'successMessage' => 'Email was successfully sent!'], 200);
    }
}
