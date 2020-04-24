<?php

namespace App\Http\Controllers;

use App\Jobs\SendMail;
use App\Jobs\DbSaveData;
use App\Repositories\DatabaseRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\FileRepository;
use App\Repositories\FtpRepository;



class HomeController extends Controller
{
    private $excelRepo;
    private $ftpRepo;
    private $fileRepo;
    private $dbRepo;

    public function __construct(ExcelRepository $excelRepo,FtpRepository $ftpRepo,
                                FileRepository $fileRepo,DatabaseRepository $dbRepo)
    {
        $this->excelRepo = $excelRepo;
        $this->ftpRepo = $ftpRepo;
        $this->fileRepo = $fileRepo;
        $this->dbRepo = $dbRepo;
    }

    public function index()
    {
        $files = $this->ftpRepo->fetchFilesName("/categories/");
        $files = $this->fileRepo->filterByExtension($files,"xlsx");
        $fileFtpPath = $this->fileRepo->fetchPathByDate($files,'@\d+@m');
        $this->ftpRepo->downloadFile($fileFtpPath);
        $dataArray = $this->excelRepo->getData($fileFtpPath);
        $dataArray = $this->excelRepo->deleteHeading($dataArray);
        $this->dispatch(new DbSaveData($dataArray));
        $this->dispatch(new SendMail());
        $bilgi = "İşlemler bitince eposta ile bilgilendirme mesajı yollanacaktır.";
        return view('welcome',compact('bilgi'));
    }



















    /*function fetchFtpFiles($directory){
        return Storage::disk('ftp')->files($directory);
    }*/
    /*function filterFileByExtension($ftpFiles,$extension){
        $xlsxFiles=[];
        foreach ($ftpFiles as $ftpFile){
            if (pathinfo($ftpFile,PATHINFO_EXTENSION)==$extension){

                array_push($xlsxFiles,$ftpFile);
            }
        }
        return $xlsxFiles;
    }*/
    /*function fetchFilePathByDate($files,$pattern){
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
    }*/
    /*function downloadFileFromFtp($filePath){
        $file = Storage::disk('ftp')->get($filePath);
        Storage::disk('local')->put(basename($filePath),$file);
    }*/
    /*function getExcelData($filePath){
        return Excel::toArray(new ExcelImport, basename($filePath));
    }*/

}
