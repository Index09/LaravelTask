<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class ProductController extends Controller
{
    public function Import(Request $request){

      $chuncks = 1;


      //save file localy
      $FileName = time().'.'.$request->ExcelFile->getClientOriginalExtension();
      $request->ExcelFile->move(public_path(''), $FileName);

      LazyCollection::make(function () use($FileName,$chuncks) {
       
        
        $filePath = public_path($FileName);
        $handle = fopen($filePath, 'r');
        while ($line = fgetcsv($handle)) {
            yield $line;
        }
        })
          ->skip(1)
          ->chunk($chuncks)
          ->each(function ($lines) {
            $list = [];
            foreach ($lines as $line) {
                if (isset($line[1])) {
                    $list[] = [                                //handle mapping proplem 
                        'name' =>  isset($line[0]) == true ? $line[0]:null, 
                        'type' =>  isset($line[1]) == true ? $line[1]:null, 
                        'qty' =>   isset($line[2]) == true ? $line[2]:null, 
                    ];
                }
            }
         //   dd($list);
            product::insert($list);
        });




      

    }

     public function ImportView()
    {
        return view('product.import');
    }
    
}
