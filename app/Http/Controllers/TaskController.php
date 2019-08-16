<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\PermissionController;
use App\Jobs\SendMailJob;
use App\Jobs\UploadFileJob;
use App\Mail\TaskMail;
use App\Models\Tasks;
use App\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
    function save_files($files_array, $id){
        $filenames = array();
        foreach($files_array as $file){
            $generated_filename = time().'_'.$file->getClientOriginalName();
//            $file->move(storage_path('uploads'), $generated_filename);
//            $file->store('uploads', 'public');


//            Storage::disk('public')->put($generated_filename, 'Contents');
            $file_path = $file->storeAs('public', $generated_filename);

            array_push($filenames, $generated_filename);
        }
        Tasks::whereIn('id', [$id])->update(['files'=>implode(';',$filenames)]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = auth()->id();
        $files = $data['files'] ?? null;

        $data['files'] = null;
        $item = new Tasks($data);
        $item->save();


        if (isset($files)) $this->save_files($files, $item->id);

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
    public function downloadFile($file){

        $url = Storage::url('file1.jpg');

        return Storage::download($url);


    }
    public function edit($id)
    {
        $permission = $this->permission();
        $item= Tasks::where('id','=',$id)->first();
        $filenames_array = explode(";", $item->files);

        return view('tasks.edit', compact("item", "permission", "filenames_array"));
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
