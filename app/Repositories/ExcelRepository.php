<?php

namespace App\Repositories;

use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelRepository
{
    public function getData($filePath)
    {
        return Excel::toArray(new ExcelImport, basename($filePath));
    }
    public function deleteHeading($data)
    {
        unset($data[0][0]);
        return $data;
    }
}




