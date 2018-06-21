<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.profile' , [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
//            dd($request->all());

        $this->validate($request , [
           'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::user()->id),
            ],
//           'password' => 'required',
           'avatar' => 'nullable|image',
        ]);

        $user = Auth::user();
        $user->edit($request->all());
        $user->generatePassword($request->get('password'));
        $user->uploadeAvatar($request->file('avatar'));

        return redirect()->back()->with('status', 'Профиль успешно обновлен');
    }
}
