<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all the contact entries from the database
        $contacts = Contact::all(); // get all the contacts
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        contact::create($validateData);
        session()->flash('success', 'Thêm mới contact thành công!');
        return redirect()->route('admin.contact');
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
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        $contact = contact::findOrFail($id);
        $contact->update($validateData);
        session()->flash('success', 'contact được cập nhật thành công!');
        return redirect()->route('admin.contact');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $recaptchaResponse = $request->input('recaptcha_response');

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
        $contact = contact::findOrFail($id);
        $contact->delete();
        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully.'
        ]);
    }
    public function hide(string $id)
    {
        $contact = contact::find($id);
        $contact->status = !$contact->status;
        $contact->save();
        if (!$contact->status)
            session()->flash('success', 'contact đã được ẩn thành công!');
        else if ($contact->status)
            session()->flash('success', 'contact đã được hiện thành công!');
        return redirect()->route('admin.contact');
    }
    public function updateStatus(Request $request, $id)
    {
        $contact = contact::find($id);
        $contact->status = $request->status;
        $contact->save();
        if ($contact->status == 0)
            session()->flash('success', 'contact đã được chuyển thành chưa xử lý!');
        else if ($contact->status == 1)
            session()->flash('success', 'contact đã được chuyển thành đang xử lý!');
        else if ($contact->status == 2)
            session()->flash('success', 'contact đã được chuyển thành đã xử lý!');
        return redirect()->route('admin.contact');
    }
}
