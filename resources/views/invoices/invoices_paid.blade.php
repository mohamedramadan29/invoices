@extends('layouts.master')
@section('title')
    قائمة الفواتير - برنامج الفواتير
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        @if(session()->has('delete'))
            <script>
                window.onload = function (){
                    notif({
                        msg:'تم حذف الفاتورة بنجاج',
                        type:"success",
                    });
                }
            </script>

        @endif

        <!--div-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-primary"  href="invoices/create"> اضافة فاتورة  <i class="fa fa-plus"></i>  </a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة </th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0"> المنتج  </th>
                                <th class="border-bottom-0">القسم </th>
                                <th class="border-bottom-0">الخصم  </th>
                                <th class="border-bottom-0">تسبة الضريبة  </th>
                                <th class="border-bottom-0">قيمة الضريبة  </th>
                                <th class="border-bottom-0">الاجمالي  </th>
                                <th class="border-bottom-0">الحالة </th>
                                <th class="border-bottom-0">ملاحظات </th>
                                <th class="border-bottom-0"> العمليات  </th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($invoices as $invoice)
                                @php
                                    $i++;
                                @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$invoice->invoice_number}}</td>
                                    <td>{{$invoice->invoice_date}}</td>
                                    <td>{{$invoice->due_date}}</td>
                                    <td>{{$invoice->product}}</td>
                                    <td> <a href="invoicesdetails/{{$invoice->id}}"> {{$invoice->section->section_name }} </a>  </td>

                                    <td>{{$invoice->discount}}</td>
                                    <td>{{$invoice->rate_vat}}</td>
                                    <td>{{$invoice->value_vat}}</td>
                                    <td>{{$invoice->total}}</td>
                                    <td>
                                        @if($invoice->status == 1)
                                            <span class="btn btn-danger btn-sm"> {{$invoice->status}} </span>
                                        @elseif($invoice->status == 2)
                                            <span class="btn btn-success btn-sm"> {{$invoice->status}} </span>
                                        @else
                                            <span class="btn btn-warning btn-sm"> {{$invoice->status}} </span>
                                        @endif
                                    </td>
                                    <td>{{$invoice->note}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm"
                                                    data-toggle="dropdown" id="dropdownMenuButton" type="button"> العمليات  <i class="fas fa-caret-down ml-1"></i></button>
                                            <div  class="dropdown-menu tx-13">
                                                <a class="dropdown-item" href="{{url("edit_invoice")}}/{{$invoice->id}}">تعديل الفاتورة </a>
                                                <a class="modal-effect dropdown-item" data-effect="effect-scale" data-id= "{{$invoice->id}}" data-toggle="modal" href="#modaldemo_delete">  <i class="fa fa-trash"></i> حذف الفاتورة  </a>
                                                <a class="dropdown-item" href="{{url('status_show')}}/{{$invoice->id}}"> <i class="fa fa-dollar"></i> تعديل حالة الدفع  </a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!--div-->
        <!-- start delete module -->
        <div class="modal" id="modaldemo_delete">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> حذف الفاتورة  </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    @if(isset($invoice))
                        <form action="{{route('invoices.destroy','delete')}}" method="post">
                            {{method_field('delete')}}
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <label> هل انت متاكد من حذف الفاتورة </label>

                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-primary" type="submit"> تاكيد  </button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <!-- end delete module -->

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        $("#modaldemo_delete").on('show.bs.modal',function (event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
        })
    </script>

    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
@endsection
