<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class AdminContactController extends Controller
{
    public function index()
    {
        if (!auth()->user()?->is_admin) {
            abort(403);
        }

        $contacts = Contact::latest()->paginate(50);

        return view('admin.contacts.index', compact('contacts'));
    }

}