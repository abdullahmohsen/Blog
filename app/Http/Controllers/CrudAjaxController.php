<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\PostTrait;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CrudAjaxController extends Controller
{
    use PostTrait;

    // public function create()
    // {
    //     return view('posts');
    // }

    public function store(PostRequest $request)
    {
        // $data = Validator::make($request->all(),[
        //     'title' => 'required|string|max:100',
        //     'desc' => 'required|string',
        //     'content' => 'required|string',
        //     'image' => 'required|image|mimes:png,jpg,jpeg',
        // ]);

        // if ($data->fails())
        // {
        //     return response()->json(array('errors'=> $validator->getMessageBag()->toarray()));
        // }

        if ($request->hasFile('image'))
        {
            $imageName = $this->saveImage($request->image, 'assets/uploads');
        }
        else
        {
            $imageName = "no image";
        }

        $post = new Post();
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->content = $request->content;
        $post->user_id = auth()->user()->id;
        $post->image = $imageName;
        $post->save();

        return response()->json(['success'=>'Your Post Created successfully.']);

    }

    // public function edit(Request $request)
    // {
    //     $post = Post::findOrFail($request->post_id);

    //     return view('posts', compact('post'));
    // }


    public function update(PostRequest $request)
    {
        $post = Post::findOrFail($request->id);

        //Image
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

        return response()->json(['success'=>'Your Post Updated successfully.']);
    }


    public function destroy(Request $request)
    {
        $post = Post::findOrFail($request->id);

        //Check for correct user
        // if(auth()->user()->id !== $post->user_id)
        // {
        //     return redirect(route('index.home'))->with('error', 'Unauthorized Page');
        // }

        //Delete image
        $old_name = $post->image;
        Storage::disk('uploads')->delete($old_name);

        $post->delete();
        return response()->json([
            'success'=>'Post Removed',
            'id'=>$request->id
        ]);

    }
}
