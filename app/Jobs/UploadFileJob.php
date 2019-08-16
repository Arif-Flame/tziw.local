<?php

namespace App\Jobs;

use App\Models\Tasks;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data, $id;

    public function __construct($data, $id)
    {
        $this->data = $data;
        info($this->data);
        $this->task_id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $filenames = array();


        foreach($this->data as $file){
            $generated_filename = time().'_'.$file->getClientOriginalName();
            $file->move(storage_path('uploads'), $generated_filename);
            array_push($filenames, $generated_filename);
        }
        $task = Tasks::where('id', '=', $this->task_id);
        $task->files = $filenames;
        $task->save();
    }
}
