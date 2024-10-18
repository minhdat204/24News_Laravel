<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use ReCaptcha\ReCaptcha;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all(); // get all the contacts
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Category::create($validateData);
        session()->flash('success', 'Thêm mới category thành công!');
        return redirect()->route('admin.category');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category = Category::findOrFail($id);
        $category->update($validateData);
        session()->flash('success', 'Category được cập nhật thành công!');
        return redirect()->route('admin.category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Xác thực CAPTCHA
        // $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        // $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        // if (!$response->isSuccess()) {
        //     return response()->json(['error' => 'CAPTCHA không hợp lệ.'], 422);
        // }

        // Tìm và xóa danh mục
        // Xác minh reCAPTCHA






        // $recaptchaToken = $request->input('g-recaptcha');
        // $client = new Client();
        // $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
        //     'form_params' => [
        //         'secret' => env('RECAPTCHA_SECRET_KEY'),
        //         'response' => $recaptchaToken,
        //     ]
        // ]);

        // $body = json_decode((string)$response->getBody());

        // if (!$body->success) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Captcha verification failed.'
        //     ]);
        // }

        // Lấy token reCAPTCHA từ request (lúc tick vào ô check im not robot)
        $recaptchaResponse = $request->input('recaptcha_response');
        // Gửi yêu cầu xác minh đến Google
        //cách 1: gắn thẳng query vào url
        // $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . env('RECAPTCHA_SECRET_KEY') . '&response=' . $recaptchaResponse);
        // $recaptcha = json_decode($recaptcha);

        //cách 2: tạo client + truyền mảng chứa secret và capcha token
        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $recaptchaResponse,
            ]
        ]); // -> trả về json

        $recaptcha = json_decode((string)$response->getBody()); // -> tách json thành đối tượng

        // Kiểm tra xác minh reCAPTCHA
        if (!$recaptcha->success) {
            return response()->json([
                'success' => false,
                'message' => 'CAPTCHA verification failed.'
            ], 400);
        }

        $category = Category::findOrFail($id);
        if ($category) {
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found.'
            ], 404);
        }
    }

    public function hide(string $id)
    {
        $category = Category::find($id);
        $category->status = !$category->status;
        $category->save();
        if (!$category->status)
            session()->flash('success', 'Category đã được ẩn thành công!');
        else if ($category->status)
            session()->flash('success', 'Category đã được hiện thành công!');
        return redirect()->route('admin.category');
    }
}