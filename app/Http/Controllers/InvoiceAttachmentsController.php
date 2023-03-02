<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
        $attachment = new invoice_attachments();
        $attachment->file_name = $file_name;
        $attachment->invoices_number = $request->invoice_number;
        $attachment->invoices_id = $request->invoice_id;
        $attachment->created_by = Auth::user()->name;
        $attachment->save();
        // mov_pic
        $imagename = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('attachments/'.$request->invoice_number),$imagename);
        session()->flash('add','تم اضافة المرفق بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = invoice_attachments::findOrFail($request->id_file);
        $invoice->delete();
        Storage::disk('public_upload')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete','تم حذف المرفق بنجاح ');
        return back();
    }
}
