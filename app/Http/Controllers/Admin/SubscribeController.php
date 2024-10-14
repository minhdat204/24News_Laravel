<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = Subscriber::all(); // get all the contacts
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function unSubscribed($id)
    {
        $unsubscribedSubscribers = Subscriber::find($id);
        $unsubscribedSubscribers->delete(); // update the status to unsubscribed
        return redirect()->route('admin.subscribe')->with('success', 'Subscriber Unsubscribed Successfully');
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
            'email' => 'required|string|max:255',
        ]);
        $validateData['subscribed_at'] = now();
        Subscriber::create($validateData);
        session()->flash('success', 'Thêm mới subscribe thành công!');
        return redirect()->route('admin.subscribe');
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
            'email' => 'required|string|max:255',
        ]);
        $subscribe = subscriber::findOrFail($id);
        $subscribe->update($validateData);
        session()->flash('success', 'subscribe được cập nhật thành công!');
        return redirect()->route('admin.subscribe');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subscribe = subscriber::find($id);
        $subscribe->delete();
        return redirect()->route('admin.subscribe')->with('success', 'subscribe deleted successfully.');
    }

    public function bulkActions(Request $request)
    {
        $action = $request->input('action');
        $subscriberIds = $request->input('subscriber_ids');

        if (!$subscriberIds) {
            return back()->withErrors(['No subscribers selected']);
        }

        switch ($action) {
            case 'delete':
                Subscriber::whereIn('id', $subscriberIds)->delete();
                session()->flash('success', 'Selected subscribers deleted successfully!');
                break;

            case 'activate':
                Subscriber::whereIn('id', $subscriberIds)->update(['status' => 1]);
                session()->flash('success', 'Selected subscribers activated successfully!');
                break;

            case 'export':
                // Implement export logic here (e.g., exporting subscribers to CSV)
                session()->flash('success', 'Subscribers exported successfully!');
                break;

            default:
                return back()->withErrors(['action' => 'Invalid action selected']);
        }

        return redirect()->route('admin.subscribe');
    }
}