<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // pastikan penulisan resource benar
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Post::latest()->paginate(5);

        //return collection of posts as a resource
        return PostResource::collection($posts);
    }

    /**
     * store
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/post', $image->hashName());

        //create post
        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,  // Perbaiki typo di sini
            'content' => $request->content,
        ]);

        //return respons
        return new PostResource(true, 'Data Post Berhasil ditambahkan', $post);
    }

    /**
     * show
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $post= Post::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Post!', $post);
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rule
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Post::find($id);

        //check if image is note empty
        if ($request->hasFile('image')) {
            //upload image
            $image = $request->file('image');
            $image->storeAs('public/post', $image->hashName());

            //delete old image
            Storage::delete('public/post/' . basename($post->image));

            //update post with new image
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'content' => $request->content,
            ]);
        } else {
            //update post without image
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah', $post);
    }

    /**
     * destroy 
     * 
     * @param mixed $id
     * @return void
     */

     public function destroy($id)
     {

        //find post by ID
        $post = Post::find($id);

        //delete image
        Storage::delete('public/post/'.basename($post->image));

        //delete post
        $post->delete();

        //return response
        return new PostResource(true, 'Data Post Berhasil Dihapus!', null);
     }
}