<?php

namespace App\Repositories;

use App\Category;

class DatabaseRepository
{
    public function saveDataCategoryTable($data)
    {
        foreach ($data[0] as $categoryName) {
            if (!(Category::where('category_name',$categoryName[0])->first()) && isset($categoryName[0])){
                $category = new Category(['category_name' => $categoryName[0]]);
                $category->save();
            }
            if(!(Category::where('category_name',$categoryName[1])->first()) && isset($categoryName[1])){
                $parent = Category::where('category_name',$categoryName[0])->first();
                $children = new Category(['category_name' => $categoryName[1]]);
                $children->appendToNode($parent)->save();
            }
            if(!(Category::where('category_name',$categoryName[2])->first()) && isset($categoryName[2])){
                $parent = Category::where('category_name',$categoryName[1])->first();
                $children = new Category(['category_name' => $categoryName[2]]);
                $children->appendToNode($parent)->save();
            }
        }
    }

}
