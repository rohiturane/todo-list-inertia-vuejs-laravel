<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TodoList;
use App\User;


class WelcomeController extends Controller
{
    public function index()
    {
        return Inertia::render('index', [
            'users' => User::get()            
        ]);
    }
    public function store(Request $request) 
    {
        $user_id = $request->input('user_id');
        $title = $request->input('title');
        $validate = Validator::make(['user_id'=>$user_id,'title'=>$title], [
            'title' => 'required|max:255',
            'user_id' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['status'=>false, 'message'=>$validate->errors()]);
        } 

        $todo = TodoList::insert(['title'=>$title,'user_id'=>$user_id]);

        return response()->json(['status'=>true,'message'=>'Todo Save Successfully']);
    }
    public function destory(Request $request)
    {   
        $todo = TodoList::where('id', $request->input('id'))->delete();
        return response()->json(['status'=>true,'message'=>'Todo deleted']);
    }
    public function todoList()
    {
        $todolist = TodoList::with('user')->get();
        $users = User::with('todos')->get();
        return response()->json(['todolist'=>$todolist,'users'=>$users]);
    }
    public function update(Request $request,$id)
    {
        $user_id = $request->input('user_id');
        $title = $request->input('title');
        $validate = Validator::make(['user_id'=>$user_id,'title'=>$title], [
            'title' => 'required|max:255',
            'user_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['status'=>false, 'message'=>$validate->errors()]);
        } 

        $todo = TodoList::find($id);
        $todo->title = $title;
        $todo->user_id= $user_id;
        $todo->save();

        return response()->json(['status'=>true,'message'=>'Todo updated successfully']);
    }
    public function updateStatus(Request $request)
    {
        $todo = TodoList::find($request->input('id'));
        $todo->status=1;
        $todo->save();
        return response()->json(['status'=>true,'message'=>'Todo Task Completed']);
    }
}