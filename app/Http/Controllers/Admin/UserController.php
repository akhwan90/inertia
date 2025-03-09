<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    //
    public function index() {
        $users = User::paginate(100);

        return Inertia::render('Admin/Users/Index', compact(
            'users'
        ));
    }
}
