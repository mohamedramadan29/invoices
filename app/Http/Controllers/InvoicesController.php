<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.add',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number'=>$request->invoice_number,
            'invoice_date'=>$request->invoice_date,
            'due_date'=>$request->due_date,
            'product'=>$request->product,
            'section_id'=>$request->section,
            'amount_collection'=>$request->amount_collection,
            'amount_commision'=>$request->amount_commision,
            'discount'=>$request->discount,
            'value_vat'=>$request->value_vat,
            'rate_vat'=>$request->rate_vat,
            'total'=>$request->total,
            'status'=>'غير مدفوعه',
            'value_status'=>2,
            'note'=>$request->note,
            'user'=>Auth::user()->name
        ]);
        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'id_invoice'=>$invoice_id,
            "invoice_number"=>$request->invoice_number,
            "product"=>$request->product,
            "section"=>$request->section,
            "status"=>'غير مدفوعه',
            "value_status"=>2,
            "notes"=>$request->note,
            'user'=>Auth::user()->name
        ]);

        if($request->hasFile('pic')){
            $invoice_id = invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            invoice_attachments::create([
                'file_name'=>$file_name,
                'invoices_number'=>$invoice_number,
                'created_by'=>Auth::user()->name,
                'invoices_id'=>$invoice_id,
            ]);
            // move pic
            $imagename = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('attachments/'.$invoice_number),$imagename);
        }
        Session()->flash('add','تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = invoices::where('id',$id)->first();
        $sections = sections::all();
        return view('invoices.edit',compact('invoice','sections'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = invoices::findOrFail($request->id);
        $invoice->update([
            'invoice_number'=>$request->invoice_number,
            'invoice_date'=>$request->invoice_date,
            'due_date'=>$request->due_date,
            'product'=>$request->product,
            'section_id'=>$request->section,
            'amount_collection'=>$request->amount_collection,
            'amount_commision'=>$request->amount_commision,
            'discount'=>$request->discount,
            'value_vat'=>$request->value_vat,
            'rate_vat'=>$request->rate_vat,
            'total'=>$request->total,
            'note'=>$request->note,
            'user'=>Auth::user()->name
        ]);
        session()->flash('edit','تم تعديل الفاتورة بنجاح ');
        return  back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices $invoices)
    {
        //
    }
    public function getproducts($id){
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

}
