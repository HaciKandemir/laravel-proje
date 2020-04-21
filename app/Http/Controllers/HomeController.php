<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseRepository;
use App\Repositories\ExcelRepository;
use App\Repositories\FileRepository;
use App\Repositories\FtpRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use App\Imports\ExcelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Category;

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
        //$files = $this->fetchFtpFiles("/categories/");
        $files = $this->ftpRepo->fetchFilesName("/categories/");

        //$files = $this->filterFileByExtension($files,"xlsx");
        $files=$this->fileRepo->filterByExtension($files,"xlsx");

        //$fileFtpPath = $this->fetchFilePathByDate($files,'@\d+@m');
        $fileFtpPath = $this->fileRepo->fetchPathByDate($files,'@\d+@m');

        //$this->downloadFileFromFtp($fileFtpPath);
        $this->ftpRepo->downloadFile($fileFtpPath);

        //$array = $this->getExcelData($fileFtpPath);
        $dataArray = $this->excelRepo->getData($fileFtpPath);

        //unset($dataArray[0][0]);
        $dataArray = $this->excelRepo->deleteHeading($dataArray);

        /*foreach ($dataArray[0] as $dizi){
            if (!(Category::where('category_name',$dizi[0])->first())){
                $category = new Category(['category_name' => $dizi[0]]);
                $category->save();
            }
            if(!(Category::where('category_name',$dizi[1])->first())){
                $parent = Category::where('category_name',$dizi[0])->first();
                $children = new Category(['category_name' => $dizi[1]]);
                $children->appendToNode($parent)->save();
            }
            if(!(Category::where('category_name',$dizi[2])->first())&&isset($dizi[2])){
                $parent = Category::where('category_name',$dizi[1])->first();
                $children = new Category(['category_name' => $dizi[2]]);
                $children->appendToNode($parent)->save();
            }
        }*/
        $this->dbRepo->saveDataCategoryTable($dataArray);

        $bilgi = "Sunucudaki dosya indirilip veriler veritabanına kaydedildi";

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
