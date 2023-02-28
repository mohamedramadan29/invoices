<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allsections = sections::all();
        return view('sections.sections',compact('allsections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    $inputs = $request->all();
        // التاكد من التسجيل مسبقا
      /*  $if_exist_name = sections::where('section_name','=',$inputs['section_name'])->exists();
        if($if_exist_name){
            session()->flash('error','القسم مسجل من قبل');
            return  redirect('/sections');*/
      /*  }else{*/

        $sections_validation = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
            ],[
            'section_name.required'=>'يرجي ادخال اسم القسم',
            'section_name.unique'=>' اسم القسم موجود من قبل من فضلك ادخل اسم قسم جديد ',
            'description.required'=>'  من فضلك ادخل الوصف الخاص بالقسم   ',
        ]);


            sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>(Auth::user()->name)
            ]);
            session()->flash('add','تم اضافة القسم بنجاح');
            return redirect('/sections');
        }

   // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $edit_validation = $request->validate([
            'section_name' => 'required|unique:sections,section_name,'.$id,
            'description' => 'required',
            ],[
                'section_name.required'=>'يرجي ادخال اسم القسم',
                'section_name.unique'=>' اسم القسم موجود من قبل من فضلك ادخل اسم قسم جديد ',
                'description.required'=>'  من فضلك ادخل الوصف الخاص بالقسم   ',
        ]);
        $section = sections::find($id);
        $section->update([
            'section_name'=>$request->section_name,
            'description'=>$request->description
        ]);
        session()->flash('edit','تم تعديل القسم بنجاح ');
      return  redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
