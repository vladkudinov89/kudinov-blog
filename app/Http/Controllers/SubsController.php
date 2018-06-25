<?php

namespace App\Http\Controllers;

use App\Mail\SubscribeEmail;
use App\Subscription;
use Illuminate\Http\Request;

class SubsController extends Controller
{
    public function subscribe(Request $request)
    {
        //dd($request->all());
        $this->validate($request , [
           'email' => 'required|email|unique:subscriptions'
        ]);

       $subs = Subscription::add($request->get('email'));

        \Mail::to($subs)->send(new SubscribeEmail($subs));

        return redirect()->back()->with('status' , 'Проверьте Вашу почту');
    }

    public function verify($token)
    {
//        dd($token);
        $subs = Subscription::where('token' , $token)->firstOrFail();
        //dd('ok');
        $subs->token = null;
        $subs->save();

        return redirect('/')->with('status' , 'Ваша почта подтверждена');
    }
}
