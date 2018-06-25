<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
//        dd($comments);
        return view('admin.comments.index' , [
            'comments' => $comments
        ]);
    }

    public function toggle($id)
    {
        //dd($id);
        $comment = Comment::find($id);

        $comment->toggleStatus();

        return redirect()->back();
    }

    public function destroy($id)
    {
        //dd($id);
        Comment::find($id)->delete();

        return redirect()->back();
    }
}
