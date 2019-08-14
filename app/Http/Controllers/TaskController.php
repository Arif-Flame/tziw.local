<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\PermissionController;
use App\Jobs\SendMailJob;
use App\Mail\TaskMail;
use App\Models\Tasks;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(Auth::user()->hasPermission(auth()->user()));
        $paging = Tasks::paginate(15);
        return view('tasks.index', compact('paging'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = auth()->id();
        $time = Carbon::now('GMT+3');
        $item = new Tasks($data);
        $item->save();

        $data['email']=DB::table('users')->where('id',$data['user_id'])->value('email');
        $data['user_name']=DB::table('users')->where('id',$data['user_id'])->value('name');
        $data['type'] = "creating";

        dispatch(new SendMailJob($data));
//        Mail::to($email)->send(new TaskMail($data));
        if($item)
        {

            return redirect('tasks')->with(['saved'=>"Запись отправлена"]);
        }
        else{
            return redirect('tasks.create')->with(['error'=>"Не удалось создать запись"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item= Tasks::where('id','=',$id)->first();
        return view('tasks.edit', compact("item"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item= Tasks::where('id','=',$id)->first();
//        dd($request->get('ansver'));
        $item->ansver = $request->get('ansver');
        $item->save();
        $data = $request->all();
        //dd($data);
        $data['type'] = "updating";

        dispatch(new SendMailJob($data));
        return redirect('tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Tasks::where('id','=', $id);
            $item->forceDelete();
        return redirect('tasks');
    }
}
