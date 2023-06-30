<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() {
        $listAccess = [1,2];

        if(!in_array(Auth::user()->role, $listAccess)) {
            return  view('home');

        } else {
            $users = User::leftJoin('ref_role', 'users.role', '=', 'ref_role.kode')
                    ->paginate(10);
    
            return view('users.index', compact('users'));
        }

    }
}
