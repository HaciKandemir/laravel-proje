<?php

namespace App\Repositories;

use Carbon\Carbon;


class FileRepository
{
    public function filterByExtension($Files,$extension)
    {
        $extFiles=[];
        foreach ($Files as $ftpFile){
            if (pathinfo($ftpFile,PATHINFO_EXTENSION)==$extension){
                array_push($extFiles,$ftpFile);
            }
        }
        return $extFiles;
    }
    function fetchPathByDate($files,$pattern)
    {
        $guncel=null;
        foreach ($files as $file){
            preg_match($pattern,$file,$datetime);
            $datetime = Carbon::parse($datetime[0])->toDateTimeString();
            if ($datetime>$guncel['date']){
                $guncel['date']=$datetime;
                $guncel['file']=$file;
            }
        }
        return $guncel['file'];
    }
}