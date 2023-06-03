<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::leftJoin('ref_role', 'users.role', '=', 'ref_role.kode')
                // ->select('users.*', 'ref_role.role')
                ->paginate(10);

        // dd($users);

        return view('users.index', compact('users'));
    }
}
