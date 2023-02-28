<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();
        return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name'=>'required',
            'section_id'=>'required',
            ],[
                'product_name.required'=>'من فضلك ادخل اسم المنتج ',
                'section_id.required'=>'من فضلك اخترالقسم الخاص بالمنتج ',
        ]);
        products::create([
            'product_name'=>$request->product_name,
            'product_description'=>$request->product_description,
            'section_id'=>$request->section_id
            ]);
        session()->flash('add','تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

     //   $section_id = sections::where('section_name',$request->section_name)->first()->id;
        $section_id = $request->section_name;
         $product= products::findorFail($request->id);
         $product->update([
             'product_name'=>$request->product_name,
             'product_description'=>$request->product_description,
             'section_id'=>$section_id
         ]);
         session()->flash('edit','تم تعديل المنتج بنجاح ');
         return  redirect('/products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //$id = $request->id;
        $product = products::findorfail($request->id);
        $product->delete();
        session()->flash('delete','تم حذف المنتج بنجاج');
        return back();
    }
}
