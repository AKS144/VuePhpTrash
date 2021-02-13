<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
   
    public function index()
    {
        /*$models = Post::orderBy('created_at', 'desc')->get();
        return view('post.index', ['posts'=>$models]);*/

        /*//for trash recycle and trash,restore,remove are to be used after
        $models = Post::orderBy('created_at', 'desc')->with('user:id,name')->get();
        return view('post.index', ['posts'=>$models, 'trash'=> false ]);*/
    
        //after vue adding in video 38 for print out post.index to post.table
        $models = Post::orderBy('created_at', 'desc')->with('user:id,name')->get();
        return view('post.table', ['posts'=>$models, 'trash'=> false ]);
    
    }

    public function trash()
    {
        /*$models = Post::onlyTrashed('deleted_at', 'asc')->with('user:id,name')->get();
        return view('post.index', ['posts'=>$models, 'trash'=> true ]);*/

        //after vue adding video 38 for printout
        $models = Post::onlyTrashed('deleted_at', 'asc')->with('user:id,name')->get();
        return view('post.table', ['posts'=>$models, 'trash'=> true ]);
    }

    public function restore($id)
    {
        Post::withTrashed()->where('id',$id)->restore();
        return redirect(route('posts.trash'));
    }

    public function remove(Request $request)
    {
        Post::onlyTrashed()->where('id', $request->get('id'))->forceDelete();
        return redirect(route('posts.trash'));
    }

    public function assign($url)
    {
        return redirect(route($url));
    }
 
    public function create()
    {
        return view('post.form', ['author'=>Auth::id()]);
    }

    
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'title' =>'required|unique:posts|max:255',
            'content' => 'required',
            'tags' => 'required',
            'slug' => 'required',
            'thumbnail'=> 'required',
            'author'=> 'required',
            'status' => 'required'
        ],[
            'required' => 'The :attribute field is required.',
            'title.max' => 'The maximum value of title field should not more than 255 character.',
            'title.unique' => 'The title must be unique for posts.',
        ])->validate();

        $model =Post::create($request->all());
        if($model){
            return redirect('posts');
        }
        else
        {
            return redirect('posts/create')->with('error','Error! Request data is not insert to database');
        }
    }

   
    public function show(Post $post)
    {
        $model = Post::find($post->id);
        $author = \App\User::where('id', $post->author)->first();
        return view('post.preview',['post'=>$model,'author'=>$author]);
    }

    public function edit(Post $post)
    {
        $model = Post::find($post->id);
        return view('post.form',['post'=>$model,'author'=>Auth::id()]);
    }

   
    public function update(Request $request, Post $post)
    {
         Validator::make($request->all(),[
            'title' =>'required|max:255',
            'content' => 'required',
            'tags' => 'required',
            'slug' => 'required',
            'thumbnail'=> 'required',
            'author'=> 'required',
            'status' => 'required'
         ],[
             [
            'required' => 'The :attribute field is required.',
            'title.max' => 'The maximum value of title field should not more than 255 character.',
            'title.unique' => 'The title must be unique for posts.',
        ]
         ])->validate();

        $model = Post::where('id',$post->id)->update($request->except(['_token','_method']));
        if($model){
            return redirect('posts');
        }
        else{
            return redirect('posts/'.$post->id.'/edit')->with('error','Error! Failed to update request');
        }
    }

   
    public function destroy(Post $post)
    {
        Post::destroy($post->id);
        return redirect('posts');
    }
}
