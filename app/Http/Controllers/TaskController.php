<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\PermissionController;
use App\Jobs\SendMailJob;
use App\Jobs\UploadFileJob;
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
    public function permission()
    {
        return Auth::user()->hasPermission(\auth()->id());
    }


    public function index()
    {
//            dd($this->permission());
            $permission = $this->permission();

            $paging = Tasks::paginate(15);
            return view('tasks.index', compact('paging', 'permission'));



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
//        dd($data["files"][0]->getClientOriginalName());

//        if(count($data["files"]>15)){
//            $data["files"] = array_slice($data["files"], 0,15);
//        }



//        $time = Carbon::now('GMT+3');
        $files=$data["files"];
        $data["files"] = "Hello";
        $item = new Tasks($data);
        $item->save();

        dispatch(new UploadFileJob($files, $item->id));


        // Очередь на загрузку файлов!

        $data['type'] = "creating";
        $data['ansver'] = null;

        // Очередь на отправку почты!
        dispatch(new SendMailJob($data));

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
        $permission = $this->permission();
        $item= Tasks::where('id','=',$id)->first();
        return view('tasks.edit', compact("item", "permission"));
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
