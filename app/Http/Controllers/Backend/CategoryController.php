<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //
    public function view(){
        $category = Category::latest()->get();
        return view('backend.category.view',compact('category'));
    }

    public function store(Request $request){

         $request->validate([
    		'category_name_en' => 'required',
    		'category_name_hin' => 'required',
    		'category_icon' => 'required',
    	],[
    		'category_name_en.required' => 'Input Category English Name',
    		'category_name_hin.required' => 'Input Category Hindi Name',
    	]);

    	 

	Category::insert([
		'category_name_en' => $request->category_name_en,
		'category_name_hin' => $request->category_name_hin,
		'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
		'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
		'category_icon' => $request->category_icon,

    	]);

	    $notification = array(
			'message' => 'Category Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return view('backend.category.edit',compact('category'));
    }

    public function update(Request $request, $id){

        
      Category::findOrFail($id)->update([
		'category_name_en' => $request->category_name_en,
		'category_name_hin' => $request->category_name_hin,
		'category_slug_en' => strtolower(str_replace(' ', '-',$request->category_name_en)),
		'category_slug_hin' => str_replace(' ', '-',$request->category_name_hin),
		'category_icon' => $request->category_icon,

    	]);

	    $notification = array(
			'message' => 'Category Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('category.list')->with($notification);

    }

    public function delete($id){

        Category::findOrFail($id)->delete();

    	$notification = array(
			'message' => 'Category Deleted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    }
}
