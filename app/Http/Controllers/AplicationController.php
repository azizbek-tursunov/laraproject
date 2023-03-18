<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class AplicationController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $name = $request->file('file')->getClientOriginalName();
            $path = $request->file->storeAs('files', $name, 'public');
        }

        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'file_url' => 'file|mimes:pdf,doc,docx,jpg,png|max:2048'
        ]);

        $application = Application::create([
            'user_id' => auth()->user()->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'file_url' => $path ?? null
        ]);

        return redirect()->back();
    }
}
