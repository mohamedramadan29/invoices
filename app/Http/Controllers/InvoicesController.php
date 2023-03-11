<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        echo "show";
    }
    public function status_show($id){
        $invoice = invoices::where("id",$id)->first();
        $sections = sections::all();
         return view('invoices.edit_status',compact('invoice','sections'));
    }
    public  function status_update($id,Request $request){
        $invoice = invoices::findOrFail($id);
        if($request->status === 'مدفوعه'){
            $invoice->update([
                'value_status'=> 1,
                'status'=>'مدفوعه',
                'payment_date'=>$request->payment_date,
            ]);
            invoices_details::create([
                'id_invoice'=>$invoice,
                "invoice_number"=>$request->invoice_number,
                "product"=>$request->product,
                "section"=>$request->section,
                "status"=>$request->status,
                "value_status"=>1,
                "notes"=>$request->note,
                'user'=>Auth::user()->name
            ]);
        }else{
            $invoice->update([
                'value_status'=> 3,
                'status'=>$request->status,
                'payment_date'=>$request->payment_date,
            ]);
            invoices_details::create([
                'id_invoice'=>$invoice,
                "invoice_number"=>$request->invoice_number,
                "product"=>$request->product,
                "section"=>$request->section,
                "status"=>$request->status,
                "value_status"=>3,
                "notes"=>$request->note,
                'user'=>Auth::user()->name
            ]);
        }

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

    public function print_invoice($id){
        $invoices = invoices::where('id',$id)->first();

        return view('invoices.print_invoice',compact('invoices'));
    }

    public function invoice_paid(){
        $invoices = invoices::where('value_status',1)->get();
        //return view('invoices.paid',compact('invoices'));
        return view('invoices.invoices_paid',compact('invoices'));
    }
    public function invoice_unpaid(){
        $invoices = invoices::where('value_status',2)->get();
        return view('invoices.unpaid',compact('invoices'));
    }
    public function invoice_portal(){
        $invoices = invoices::where('value_status',3)->get();
    return view('invoices.portal',compact('invoices'));
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoive = invoices::where("id",$request->id)->first();
        // لو هيتم الحذف النهائي
        $details = invoice_attachments::where('invoices_id',$request->id)->first();
        if(!empty($details->invoices_number)){
            Storage::disk('public_upload')->deleteDirectory($details->invoices_number);
        }
        $invoive->forceDelete();
        session()->flash('delete');
        return back();
    }
    public function getproducts($id){
        $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($products);
    }

}
