<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'uid' => (string) Str::random(30),
        ]);
    }

    public function index()
    {
        $listAccess = [1,2];

        if(!in_array(Auth::user()->role, $listAccess)) {
            return  view('home');

        } else {
            return view('auth/register');
        }
    }

    public function daftar()
    {
        $listAccess = [1,2];

        if(!in_array(Auth::user()->role, $listAccess)) {
            return  view('home');

        } else {
            return view('auth/register');
        }
    }

    public function tambah(Request $request)
    {
        $data = [
            'name' => $request->name,
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation
        ];
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ];
        
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            User::create([
                'name' => $data['name'],
                'nama' => $data['nama'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
                'uid' => (string) Str::random(30),
            ]);
            return redirect('users')->with('success', 'Akun ' .$request->nama . ' (' . $request->name . ')' . ' berhasil ditambahkan');
        } else {
            return redirect('users')->with('failed', 'Gagal menambah akun');
        }
    }
}
