<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, int $id){
        try{
            $no = Notification::findOrFail($id)->markAsRead();
        }catch(\Exception $e){
            return back()->with("error", 'Notification coudn\'t be found');
        }
        return back()->with('success','Notification set as read');
    }

    public function markAsUnread(Request $request, int $id){
        try{
            $no = Notification::findOrFail($id)->markAsUnread();
        }catch(\Exception $e){
            return back()->with("error", 'Notification coudn\'t be found');
        }
        return back()->with('success','Notification set as read');
    }

    public function index(Request $request){
        return view('notifications', [
            'allNotifications'=> Notification::all(),
        ]);
    }

    public function destroy(Request $request, int $id){
        try{
            Notification::findOrFail($id)->delete();
        }catch(\Exception $e){
            return back()->with('error', 'Notification not found');
        }
        return back()->with('success','Notification deleted successfully');
    }
}
