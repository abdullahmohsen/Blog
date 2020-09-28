<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::get();
        return view('posts', compact('posts'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(),[
            'title' => 'required|string|max:100',
            'desc' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        //Lw el data feha errors
        if ($data->fails())
        {
            return back()
            ->withErrors($data)
            ->withInput();
        }

        $imageName="";
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'blog_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/uploads');
            $image->move($destinationPath, $name);
            $imageName = $name;
        }

        $post = new Post();
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->content = $request->content;
        $post->image = $imageName;
        $post->save();
        return redirect('posts')->with('success', 'Post Created');
    }

    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        return view('show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)->first();
        return view('edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $data = Validator::make($request->all(),[
            'title' => 'required|string|max:100',
            'desc' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);
        //Lw el data feha errors
        if ($data->fails())
        {
            return back()
            ->withErrors($data)
            ->withInput();
        }
        $post = Post::where('id', $id)->first();
        $old_name = $post->image;
        if ($request->hasFile('image'))
        {
            Storage::disk('uploads')->delete($old_name);
            $image = $request->file('image');
            $new_name = 'blog_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/uploads');
            $image->move($destinationPath, $new_name);
            $imageName = $new_name;
        }
        else
        {
            $imageName = $old_name;
        }

        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->content = $request->content;
        $post->image = $imageName;
        $post->save();
        return redirect('posts')->with('success', 'Post Updated');
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();

        //Delete image
        $old_name = $post->image;
        Storage::disk('uploads')->delete($old_name);

        $post->delete();
        return redirect('posts')->with('success', 'Post Removed');
    }
}
