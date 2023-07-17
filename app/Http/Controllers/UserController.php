<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    public function index() {
        $listAccess = [1,2];
        if(!in_array(Auth::user()->role, $listAccess)) {
            return  view('home');
        } else {
            $users = User::leftJoin('ref_role', 'users.role', '=', 'ref_role.kode')
                    ->where('name', '!=', 'master')
                    ->paginate(10);
            return view('users.index', compact('users'));
        }
    }

    public function edit(Request $request) {
        if (isset($request->uid)) {
            $user = User::where('uid', $request->uid)->get();
            if ($user) {
                return view('users.edit',['user'=> $user]);
            }
        }
        return redirect('users');
    }

    public function update(Request $request)
    {
        $name = $request->name;
        $nama = $request->nama;
        $validatedData = $request->validate([
            'name' => 'required',
            'nama' => 'required',
            'email' => 'required|email'
        ]);
        User::where('uid',$request->uid)->update($validatedData);

        if ($request->password) {
            User::where('uid',$request->uid)->update(['password' => Hash::make($request->password)]);
        }

        return redirect('users')->with('success', 'Akun ' . $nama . ' ( ' . $name . ') berhasil diedit');
    }

    public function resetpass(Request $request) {
        if (isset($request->uid)) {
            $uid = $request->uid;
            $newPass = Hash::make('123123');
            User::where('uid', $uid)->update(['password' => $newPass]);
            $user = User::where('uid', $uid)->get();
            if ($user) {
                $user = $user[0]->name;
                return redirect('users')->with('success', 'Akun ' . $user . ' berhasil reset passwod');
            }
        }
        return redirect('users');
    }

    public function Hapus(Request $request){
        if (isset($request->uid)) {
            $user = User::where('uid', $request->uid)->get();
            $nameUser = $user[0]->name;
            $namaUser = $user[0]->nama;
            if ($user) {
                User::where('uid', $request->uid)->delete();
                return redirect('users')->with('success', 'Hapus akun ' . $namaUser . ' (' . $nameUser . ')');
            }
            
        }
    }


}
