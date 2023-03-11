
@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
    <!---Internal Fancy uploader css-->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css')}}">
    <link href="{{URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل فاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        @if(session()->has('edit'))
            <script>
                window.onload = function (){
                    notif({
                        msg:'تم  تعديل حالة  الفاتورة بنجاج',
                        type:"success",
                    });
                }
            </script>

        @endif


        <div class="col-lg-12">
            <div class="card  box-shadow-0">
                <div class="card-header">
                </div>
                <div class="card-body pt-0">
                    <form class="form-horizontal" method="post" action="{{route('status_update',['id'=>$invoice->id])}}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        {{method_field('patch')}}
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="hidden" value="{{$invoice->id}}" name="id">
                                    <label for=""> رقم الفاتورة  </label>
                                    <input type="text" class="form-control" id="invoice_number" placeholder="" name="invoice_number" value="{{$invoice->invoice_number}}">
                                </div>
                                <div class="form-group">
                                    <label for=""> اختر القسم </label>
                                    <select class="form-control select2" name="section" id="section">

                                        @foreach($sections as $section)
                                            <option value="{{$section->id}}" @if($section->id == $invoice->section_id) selected @endif> {{$section->section_name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=""> مبلغ العمولة  </label>
                                    <input type="number" class="form-control" id="amount_commision" name="amount_commision" value="{{$invoice->amount_commision}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">  تاريخ الفاتورة </label>

                                    <div class="input-group">
                                        <input class="form-control" placeholder="MM/DD/YYYY" type="date" value="{{$invoice->invoice_date}}" name="invoice_date" id="invoice_date" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for=""> اختر المنتج </label>
                                    <select class="form-control select2" id="product" name="product">
                                        <option value="{{$invoice->product}}">{{$invoice->product}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for=""> الخصم  </label>
                                    <input type="number" class="form-control" id="discount" name="discount" placeholder="" value="{{$invoice->discount}}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">  تاريخ الاستحقاق  </label>

                                    <div class="input-group">

                                        <input class="form-control" placeholder="MM/DD/YYYY" type="date" name="due_date" id="due_date" value="{{$invoice->due_date}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=""> مبلغ التحصيل </label>
                                    <input type="text" class="form-control" id="amount_collection" placeholder="" name="amount_collection" value="{{$invoice->amount_collection}}">
                                </div>
                                <div class="form-group">
                                    <label for="">  نسبة ضريبة القيمة المضافة </label>
                                    <select class="form-control select2" name="rate_vat" id="rate_vat" onchange="ratecalc()">

                                        <option value="5" @if($invoice->rate_vat == 5) selected @endif>
                                            5 %
                                        </option>
                                        <option value="10" @if($invoice->rate_vat == 10) selected @endif>
                                            10 %
                                        </option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for=""> قيمة ضريبة القيمة المضافة </label>
                                    <input type="number" class="form-control" id="value_vat" name="value_vat" value="{{$invoice->value_vat}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for=""> الاجمالي شامل الضريبة  </label>
                                    <input type="number" class="form-control" name="total" id="total" value="{{$invoice->total}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for=""> ملاحظات </label>
                            <textarea class="form-control" placeholder="Textarea" rows="3" name="note" id="note"> {{$invoice->note}} </textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for=""> تغير حالة الفاتورة </label>
                                    <select name="status" id="" class="form-control select2">
                                        <option value=""> -- اختر حالة الدفع  --  </option>
                                        <option value="مدفوعه"> مدفوعه </option>
                                        <option value="مدفوعه جزئيا"> مدفوعه جزئيا </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for=""> تاريخ الدفع   </label>
                                    <input type="date" class="form-control" name="payment_date" id="payment_date">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary">  تحديث حالة الدفع   </button>
                                <!--   <button type="submit" class="btn btn-secondary">Cancel</button> -->
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{URL::asset('assets/js/advanced-form-elements.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
    <!-- Internal TelephoneInput js-->
    <script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->

    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>

    <script>
        $(document).ready(function (){
            $('select[name="section"]').on('change',function (){
                var sectionid = $(this).val();
                if(sectionid){
                    console.log('good');
                    $.ajax({
                        url:"{{URL::to('section')}}/" + sectionid,
                        type:"GET",
                        dataType:'json',
                        success:function (data){
                            $("select[name='product']").empty();
                            $.each(data,function (key,value){
                                $('select[name="product"]').append('<option value="'+value+'">'+value+'</option>');
                            });
                        }

                    });
                }else{
                    console.log('not work');
                }
            })
        })

    </script>
    <script>
        function ratecalc(){
            var amount_commision = parseFloat(document.getElementById('amount_commision').value);
            var discount = parseFloat(document.getElementById('discount').value);
            var rate_vat =parseFloat(document.getElementById('rate_vat').value);
            var rate_value = parseFloat(document.getElementById('value_vat').value);

            var sub_total = amount_commision - discount;
            if(typeof amount_commision === 'undefined' || !amount_commision){
                alert('من فضلك ادخل رقم العمولة');
            }else{
                var rate_value_result = sub_total * rate_vat / 100;
                var total = parseFloat(sub_total + rate_value_result);
                sum1 = parseFloat(rate_value_result).toFixed(2);
                sum2 = parseFloat(total).toFixed(2);
                document.getElementById('value_vat').value = sum1;
                document.getElementById('total').value = sum2;

            }
        }
    </script>

@endsection
