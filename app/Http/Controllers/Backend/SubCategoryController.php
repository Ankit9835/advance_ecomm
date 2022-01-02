<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class SubCategoryController extends Controller
{
    //
    public function subCategoryList(){
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        return view('backend.category.subcategory_view',compact('subcategory','categories'));
    }

    public function store(Request $request){

          $request->validate([
    		'category_id' => 'required',
    		'subcategory_name_en' => 'required',
    		'subcategory_name_hin' => 'required',
    	],[
    		'category_id.required' => 'Please select Any option',
    		'subcategory_name_en.required' => 'Input SubCategory English Name',
    	]);

    	 

	   SubCategory::insert([
		'category_id' => $request->category_id,
		'subcategory_name_en' => $request->subcategory_name_en,
		'subcategory_name_hin' => $request->subcategory_name_hin,
		'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
		'subcategory_slug_hin' => str_replace(' ', '-',$request->subcategory_name_hin),
		 

    	]);

	    $notification = array(
			'message' => 'SubCategory Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    }

			public function subCategoryEdit($id){
				$categories = Category::orderBy('category_name_en')->get();
				$subcategory = SubCategory::findOrFail($id);
				$subcategories = SubCategory::latest()->get();
			 return view('backend.category.subcategory_edit',compact('subcategory','categories','subcategories'));
			}

			public function subCategoryUpdate(Request $request){

				$subcat_id = $request->id;
				//dd($subcat_id);
    	 SubCategory::findOrFail($subcat_id)->update([
									'category_id' => $request->category_id,
									'subcategory_name_en' => $request->subcategory_name_en,
									'subcategory_name_hin' => $request->subcategory_name_hin,
									'subcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subcategory_name_en)),
									'subcategory_slug_hin' => str_replace(' ', '-',$request->subcategory_name_hin),
    	]);

	    $notification = array(
			'message' => 'SubCategory Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('sub.category.list')->with($notification);

			}

			public function subCategoryDelete($id){

				SubCategory::findOrFail($id)->delete();

			$notification = array(
			'message' => 'SubCategory Deleted Successfully',
			'alert-type' => 'info'
		);

			return redirect()->back()->with($notification);


			}

			public function subsubCategoryList(){
				$categories = Category::orderBy('category_name_en','ASC')->get();
				$subsubcategory = SubSubCategory::latest()->get();
				return view('backend.category.sub_subcategory_view',compact('subsubcategory','categories'));
			}

			public function getSubCategory($id){
			$subcat = 	SubCategory::where('category_id',$id)->orderBy('subcategory_name_en','ASC')->get();
				return json_encode($subcat);
			}

			public function GetSubSubCategory($subcategory_id){

				$subsubcat = SubSubCategory::where('subcategory_id',$subcategory_id)->orderBy('subsubcategory_name_en','ASC')->get();
				return json_encode($subsubcat);
			}

			public function subsubCategoryStore(Request $request){

				$request->validate([
    		'category_id' => 'required',
    		'subcategory_id' => 'required',
    		'subsubcategory_name_en' => 'required',
    		'subsubcategory_name_hin' => 'required',
    	],[
    		'category_id.required' => 'Please select Any option',
    		'subsubcategory_name_en.required' => 'Input SubSubCategory English Name',
    	]);

    	 

	   SubSubCategory::insert([
					'category_id' => $request->category_id,
					'subcategory_id' => $request->subcategory_id,
					'subsubcategory_name_en' => $request->subsubcategory_name_en,
					'subsubcategory_name_hin' => $request->subsubcategory_name_hin,
					'subsubcategory_slug_en' => strtolower(str_replace(' ', '-',$request->subsubcategory_name_en)),
					'subsubcategory_slug_hin' => str_replace(' ', '-',$request->subsubcategory_name_hin),
    	]);

	    $notification = array(
			'message' => 'Sub-SubCategory Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

			}

			public function subsubCategoryEdit($id){
					$categories = Category::orderBy('category_name_en','ASC')->get();
    	$subcategories = SubCategory::orderBy('subcategory_name_en','ASC')->get();
    	$subsubcategories = SubSubCategory::findOrFail($id);
    	return view('backend.category.sub_subcategory_edit',compact('categories','subcategories','subsubcategories'));
			}

			 public function subsubCategoryDelete($id){
      			 $categories = SubSubCategory::findOrFail($id)->delete();
								 $notification = array(
									'message' => 'Sub-SubCategory Deleted Successfully',
									'alert-type' => 'success'
							);
								return redirect()->back()->with($notification);
    	}

	
}
