<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments=Comment::latest()->paginate(20);
        return view('admin.comments.index',compact('comments'));
    }


    public function show(Comment $comment)
    {
        return view('admin.comments.show',compact('comment'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        alert()->success(' کامنت مورد نظر حذف شد', 'با تشکر');
        return redirect()->route('admin.comments.index');
    }

    public function changeApprove(Comment $comment)
    {
        if ($comment->getRawOriginal('approved')) {
            $comment->update([
               'approved'=>0
            ]);
        }else{
            $comment->update([
                'approved'=>1
            ]);
        }

        alert()->success('وضعیت کامنت مورد نظر تغییر کرد', 'با تشکر');
        return redirect()->route('admin.comments.index');
    }
}
