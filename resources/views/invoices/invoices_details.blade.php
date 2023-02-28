@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->

    <div class="row row-sm">

        @if(session()->has('delete'))
            <div class="alert alert-danger fade show alert-dismissible">
                <strong> {{session()->get('delete')}} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true"> &times; </span>
                </button>

            </div>
        @endif


        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">

                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab"> معلومات الفاتورة  </a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab"> حالات الدفع  </a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab"> المرفقات </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab4">
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                <tr>
                                                <th> رقم الفاتورة </th>
                                                <td> {{$invoice->invoice_number}} </td>
                                                <th> تاريخ الاصدار </th>
                                                <td> {{$invoice->invoice_date}} </td>
                                                <th> تاريخ الاستحقاق </th>
                                                <td> {{$invoice->due_date}} </td>
                                                <th> القسم </th>
                                                <td> {{$invoice->Section->section_name}} </td>
                                                </tr>
                                                <tr>
                                                    <th> المنتج  </th>
                                                    <td> {{$invoice->product}} </td>
                                                    <th> مبلغ التحصيل   </th>
                                                    <td> {{$invoice->amount_collection}} </td>
                                                    <th> مبلغ العمولة  </th>
                                                    <td> {{$invoice->amount_commision}} </td>
                                                    <th> الخصم  </th>
                                                    <td> {{$invoice->discount}} </td>
                                                </tr>
                                                <tr>
                                                    <th> نسبة الضريبة   </th>
                                                    <td> {{$invoice->rate_vat}} </td>
                                                    <th>  قيمة الضريبة    </th>
                                                    <td> {{$invoice->value_vat}} </td>
                                                    <th>  الاجمالي مع الضريبة   </th>
                                                    <td> {{$invoice->total}} </td>
                                                    <th> الحالة الحالية   </th>
                                                    <td>
                                                        @if($invoice->value_status == 1)
                                                            <span class="badge badge-pill badge-success"> {{$invoice->status}} </span>
                                                        @elseif($invoice->value_status == 2)
                                                            <span class="badge badge-pill badge-danger"> {{$invoice->status}} </span>
                                                        @else
                                                            <span class="badge badge-pill badge-warning"> {{$invoice->status}} </span>
                                                        @endif
                                                         </td>
                                                </tr>
                                                <tr>
                                                    <th>  ملاحظات </th>
                                                <td> {{$invoice->note}} </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-5">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th> # </th>
                                                        <th> رقم الفاتورة  </th>
                                                        <th> نوع المنتج  </th>
                                                        <th> القسم  </th>
                                                        <th> حالة الدفع  </th>
                                                        <th> تاريخ الدفع  </th>
                                                        <th> ملاحظات  </th>
                                                        <th> تاريخ الاضافة  </th>
                                                        <th> المستخدم  </th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $i = 0;
                                                    ?>
                                                    @foreach($invoice_details as $detail)
                                                        <?php $i++ ?>
                                                        <tr>
                                                            <td> {{ $i  }} </td>
                                                            <td>{{$detail->invoice_number}}</td>
                                                            <td>{{$detail->product}}</td>
                                                            <td>{{$invoice->Section->section_name}}</td>
                                                            <td>
                                                                @if($invoice->value_status == 1)
                                                                    <span class="badge badge-pill badge-success"> {{$invoice->status}} </span>
                                                                @elseif($invoice->value_status == 2)
                                                                    <span class="badge badge-pill badge-danger"> {{$invoice->status}} </span>
                                                                @else
                                                                    <span class="badge badge-pill badge-warning"> {{$invoice->status}} </span>
                                                                @endif
                                                            </td>
                                                            <td> </td>
                                                            <td>{{$detail->notes}} </td>
                                                            <td>{{$detail->created_at}}</td>
                                                            <td>{{$detail->user}}</td>

                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th> # </th>
                                                    <th> قام بالاضافة  </th>
                                                    <th> تاريخ الاضافة  </th>
                                                    <th> اسم الملف  </th>
                                                    <th> العمليات  </th>
                                                </tr>
                                                </thead>
                                                    <tbody>
                                                    <?php
                                                    $i = 0;
                                                    ?>
                                                    @foreach($invoice_attach as $attach)
                                                        <?php $i++ ?>
                                                        <tr>
                                                            <td>  {{ $i  }} </td>
                                                            <td> {{$attach->created_by}}  </td>
                                                            <td>  {{$attach->created_at}}  </td>
                                                            <td>  {{$attach->file_name}}  </td>
                                                            <td>
                                                                <a class="btn btn-warning btn-sm" target="_blank" href="{{url('openfile')}}/{{$invoice->invoice_number}}/{{$attach->file_name}}">  <i class="fa fa-eye"></i> عرض </a>
                                                                <a class="btn btn-primary btn-sm" target="_blank" href="{{url('download')}}/{{$invoice->invoice_number}}/{{$attach->file_name}}">  <i class="fa fa-download"></i> تحميل </a>
                                                                <a class="modal-effect btn btn-danger btn-sm" data-effect="effect-scale" data-file_name= "{{$attach->file_name}}" data-invoice_number= '{{$invoice->invoice_number}}' data-id_file="{{$attach->id}}" data-toggle="modal" href="#modaldemo_delete">  <i class="fa fa-trash"></i> حذف   </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- modal to delete attachments -->
        <!-- start delete module -->
        <div class="modal" id="modaldemo_delete">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> حذف المرفق   </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    @if(isset($attach))
                        <form action="{{url('delete_attach')}}/{{$attach->id}}" method="post">

                            {{csrf_field()}}

                            <div class="modal-body">
                                <input type="hidden" name="id_file" id="id_file">
                                <input type="hidden" name="invoice_number" id="invoice_number">
                                <input type="hidden" name="file_name" id="file_name">
                                <label> هل انت متاكد من حذف المرفق </label>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-danger" type="submit"> تاكيد  </button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- end delete module -->
        <!-- modal to delete attachments -->

    </div>

    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
<script>
    $("#modaldemo_delete").on('show.bs.modal',function (event){
        var button = $(event.relatedTarget);
        var id_file = button.data('id_file');
        var invoice_number = button.data('invoice_number');
        var file_name = button.data('file_name');
        var modal = $(this);
        modal.find('.modal-body #id_file').val(id_file);
        modal.find('.modal-body #invoice_number').val(invoice_number);
        modal.find('.modal-body #file_name').val(file_name);
    })
</script>
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Internal Input tags js-->
    <script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
    <!--- Tabs JS-->
    <script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
    <script src="{{URL::asset('assets/js/tabs.js')}}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
    <!-- Internal Prism js-->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
@endsection
