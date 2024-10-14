<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tags::all(); // get all the contacts
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        tags::create($validateData);
        session()->flash('success', 'Thêm mới tag thành công!');
        return redirect()->route('admin.tag');
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
        $tag = tags::findOrFail($id);
        $tag->update($validateData);
        session()->flash('success', 'tag được cập nhật thành công!');
        return redirect()->route('admin.tag');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = tags::find($id);
        $tag->delete();
        return redirect()->route('admin.tag')->with('success', 'tag deleted successfully.');
    }
    public function hide(string $id)
    {
        $tag = tags::find($id);
        $tag->status = !$tag->status;
        $tag->save();
        if (!$tag->status)
            session()->flash('success', 'tag đã được ẩn thành công!');
        else if ($tag->status)
            session()->flash('success', 'tag đã được hiện thành công!');
        return redirect()->route('admin.tag');
    }
}