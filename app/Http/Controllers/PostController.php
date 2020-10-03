<?php

namespace App\Http\Controllers;

use App\Events\VideoViewer;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

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
        $post->user_id = auth()->user()->id;
        $post->image = $imageName;
        $post->save();
        return redirect(route('index.home'))->with('success', 'Post Created');
    }

    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        return view('show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)->first();

        //Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect(route('index.home'))->with('error', 'Unauthorized Page');
        }

        return view('edit', compact('post'));
    }

    public function update(PostRequest $request, $id)
    {
        // $rules = [
        //     'title' => 'required|string|max:100',
        //     'desc' => 'required|string',
        //     'content' => 'required|string',
        //     'image' => 'nullable|image|mimes:png,jpg,jpeg'
        // ];

        // $data = Validator::make($request->all(), $rules,[
        //     'desc.required' => 'The description field is required.'
        // ]);

        // //Lw el data feha errors
        // if ($data->fails())
        // {
        //     // return $data->errors()->first();
        //     return back()
        //     ->withErrors($data)
        //     ->withInput();
        // }

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
        $post->user_id = auth()->user()->id;
        $post->image = $imageName;
        $post->save();
        return redirect(route('index.home'))->with('success', 'Post Updated');
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();

        //Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect(route('index.home'))->with('error', 'Unauthorized Page');
        }

        //Delete image
        $old_name = $post->image;
        Storage::disk('uploads')->delete($old_name);

        $post->delete();
        return redirect(route('index.home'))->with('success', 'Post Removed');
    }

    public function getVideo()
    {
        $video = Video::first();
        event(new VideoViewer($video));
        return view ('video')->with('video', $video);
    }
}
