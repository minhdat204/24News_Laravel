<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tags;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $posts = Post::where('status', '=', 1)->get();
        // $posts = Post::with('author', 'category', 'tags')->where('status', 1)->get();
        $posts = Post::with('author', 'category', 'tags')->get();
        $categories = Category::where('status', 1)->get();
        $authors = User::all();
        $tags = Tags::all();
        return view('admin.posts.index', compact('posts', 'categories', 'authors', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posts = Post::with('author', 'category', 'tags')->get();
        $categories = Category::where('status', 1)->get();
        $authors = User::all();
        $tags = Tags::all();
        return view('admin.posts.create', compact('posts', 'categories', 'authors', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Post::create($request->all());
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',  // Xác thực category
            'tags' => 'required|array', // Tags là một mảng các ID
            'tags.*' => 'exists:tags,id', // Mỗi tag phải tồn tại
        ]);
        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'image_path' => $request['image_path'],
            'category_id' => $validatedData['category_id'],
            'author_id' => Auth::user()->id, // Lấy ID người dùng đang đăng nhập
        ]);
        $post->tags()->attach($request->input('tags'));
        // session()->flash('success', 'Post được tạo thành công!');
        return redirect()->route('admin.post')->with('success', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::with('author', 'category', 'tags')->where('id', $id)->where('status', 1)->first(); //first : lay 1 dong
        $categories = Category::where('status', 1)->get();
        $tags = Tags::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image_path' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',  // Xác thực category
            'tags' => 'required|array', // Tags là một mảng các ID
            'tags.*' => 'exists:tags,id', // Mỗi tag phải tồn tại
        ]);
        $post = Post::find($id);
        //// $post->name = $request->name;
        //// $post->description = $request->description;
        //// $post->save();
        // $post->update($request->all());
        $post->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'image_path' => $validatedData['image_path'],
            'category_id' => $validatedData['category_id'],
        ]);
        $post->tags()->sync($request->input('tags'));
        // session()->flash('success', 'Post được cập nhật thành công!');
        return redirect()->route('admin.post')->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $captchaResponse = $request->input('recaptcha_response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secretKey,
                'response' => $captchaResponse,
            ]
        ]);

        $recaptcha = json_decode((string)$response->getBody());

        if (!$recaptcha->success) {
            return response()->json([
                'success' => false,
                'message' => 'CAPTCHA verification failed.'
            ], 400);
        }

        $post = Post::find($id);
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }
    public function hide(string $id)
    {
        $post = Post::find($id);
        $post->status = !$post->status;
        $post->save();
        if (!$post->status)
            session()->flash('success', 'Bài viết đã được ẩn thành công!');
        else if ($post->status)
            session()->flash('success', 'Bài viết đã được hiện thị thành công!');
        return redirect()->route('admin.post');
    }
}
