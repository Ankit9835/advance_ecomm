<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;

class BrandController extends Controller
{
    //
    public function view(){
        $brands = Brand::latest()->get();
        return view('backend.brand.list',compact('brands'));
    }

    public function store(Request $request){

        $request->validate([

            'brand_name_en' => 'required',
            'brand_name_hin' => 'required',
            'brand_image' => 'required',

        ],[

            'brand_name_en.required' => 'Brand Name In English Is Required',
            'brand_name_hin.required' => 'Brand Name In Hindi Is Required',
            

        ]);

        
    	$image = $request->file('brand_image');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
    	$save_url = 'upload/brand/'.$name_gen;

        Brand::create([

            'brand_name_en' => $request->brand_name_en,
            'brand_name_hin' => $request->brand_name_hin,
            'brand_slug_en' => strtolower(str_replace(' ', '-',$request->brand_name_en)),
            'brand_slug_hin' => str_replace(' ', '-',$request->brand_name_hin),
            'brand_image' => $save_url,

        ]);

         $notification = array(
			'message' => 'Brand Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    }

    public function edit($id){
        $brand = Brand::findOrFail($id);
        return view('backend.brand.edit',compact('brand'));
    }

    public function update(Request $request, $id){

        $brand_id = $request->id;
    	$old_img = $request->old_image;

    	if ($request->file('brand_image')) {

    	unlink($old_img);
    	$image = $request->file('brand_image');
    	$name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    	Image::make($image)->resize(300,300)->save('upload/brand/'.$name_gen);
    	$save_url = 'upload/brand/'.$name_gen;

	Brand::findOrFail($brand_id)->update([
		'brand_name_en' => $request->brand_name_en,
		'brand_name_hin' => $request->brand_name_hin,
		'brand_slug_en' => strtolower(str_replace(' ', '-',$request->brand_name_en)),
		'brand_slug_hin' => str_replace(' ', '-',$request->brand_name_hin),
		'brand_image' => $save_url,

    	]);

	    $notification = array(
			'message' => 'Brand Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('brand.list')->with($notification);

    	}else{

    	Brand::findOrFail($brand_id)->update([
		'brand_name_en' => $request->brand_name_en,
		'brand_name_hin' => $request->brand_name_hin,
		'brand_slug_en' => strtolower(str_replace(' ', '-',$request->brand_name_en)),
		'brand_slug_hin' => str_replace(' ', '-',$request->brand_name_hin),
		 

    	]);

	    $notification = array(
			'message' => 'Brand Updated Successfully',
			'alert-type' => 'info'
		);

		return redirect()->route('brand.list')->with($notification);

    	} // end else 

    }

    public function delete($id){

        $brand = Brand::findOrFail($id);
    	$img = $brand->brand_image;
    	unlink($img);

    	Brand::findOrFail($id)->delete();

    	 $notification = array(
			'message' => 'Brand Deleted Successfully',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);

    }
}
