<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Note;
use Carbon\Carbon;

class NotesController extends Controller
{
    public function index()
    {	
    	return view('notes');
    }

    public function store(Request $request)
    {
    	$note = new Note;
    	// validate the data
        $this->validate($request, array(
            'note'  => 'required'
        ));
        $deleted_at = Carbon::now()->addDay()->toDateTimeString();

        $note->url = substr(uniqid(), 0, 5);
        $note->note = $request->note;
        $note->deleted_at = $deleted_at;

        $note->save();

        return back()->with(['success' => 'Your temporary url for 1 day = localhost:8000/notes/'. $note->url]);
    }

    public function show($url)
    {
    	$note = Note::where('url', $url)->firstOrFail();

    	return view('notes_single', compact('note'));
    }
}
