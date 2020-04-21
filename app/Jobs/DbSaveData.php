<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\DatabaseRepository;

class DbSaveData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    private $dataArray;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataArray)
    {
        //

        $this->dataArray = $dataArray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   $dbRepo = new DatabaseRepository();
        $dbRepo->saveDataCategoryTable($this->dataArray);
    }
}
