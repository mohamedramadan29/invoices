@extends('layouts.master')
@section('title')
    المنتجات
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if(session()->has('add'))

        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>رااائع!</strong> {{session()->get('add')}}
        </div>
    @endif

    @if(session()->has('edit'))

        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>رااائع!</strong> {{session()->get('edit')}}
        </div>
    @endif

    @if(session()->has('delete'))

        <div class="alert alert-success" role="alert">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>رااائع!</strong> {{session()->get('delete')}}
        </div>
    @endif


    <!-- display Error  -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">

        <div class="col-xl-12">

            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"> اضافة منتج  جديد <i class="fa fa-plus"></i>  </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap text-center" data-page-length="50" >
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">  اسم المنتج    </th>
                                <th class="border-bottom-0">   اسم القسم   </th>
                                <th class="border-bottom-0">  الوصف   </th>
                                <th class="border-bottom-0">  العمليات   </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 0;
                            ?>
                            @foreach($products as $product)
                               <?php $i++ ?>
                                <tr>
                                    <td> {{$i}} </td>
                                    <td>   {{$product->product_name}} </td>
                                    <td> {{$product->section->section_name}} </td>
                                    <td> {{$product->product_description}} </td>
                                    <td>
                                        <a class="modal-effect btn btn-primary btn-sm" data-id="{{$product->id}}" data-product_name = "{{$product->product_name}}" data-section_name = {{$product->section->id}}
                                           data-product_description = {{$product->product_description}}
                                           data-effect="effect-scale" data-toggle="modal" href="#modaldemo_edit">  <i class="fa fa-pen"></i>  </a>
                                        <a class="modal-effect btn btn-danger btn-sm" data-effect="effect-scale" data-id= "{{$product->id}}" data-product_name= '{{$product->product_name}}' data-toggle="modal" href="#modaldemo_delete">  <i class="fa fa-trash"></i>   </a>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add New Product -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> اضافة منتج     </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('products.store')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> اسم المنتج    </label>
                                <input type="text" class="form-control" name="product_name" id="exampleInputEmail1" placeholder=" اسم المنتج ">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> اسم القسم     </label>
                                <select name="section_id" id="section_name" class="form-control select2">
                                    <option value=""> -- اختر القسم -- </option>
                                    @foreach($sections as $section)
                                        <option value="{{$section->id}}"> {{$section->section_name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for=""> وصف المنتج  </label>
                                <textarea class="form-control" name="product_description" id="product_description"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit"> تاكيد  </button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">رجوع</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- End Add New Product -->

        <!-- start edit module -->
        <div class="modal" id="modaldemo_edit">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> تعديل المنتج   </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    @if(isset($product))

                    <form action="{{route('products.update',$product->id)}}" method="post">
                        {{method_field('PATCH')}}
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> اسم المنتج    </label>
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="form-control" name="product_name" id="product_name" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> اسم القسم  </label>
                                <input type="text" class="form-control" name="section_name" id="section_name" value="">
                                <!--
                                <select name="section_name" id="section_name" class="form-control">
                                    @foreach($sections as $section)
                                        <option> {{$section->section_name}} </option>
                                    @endforeach
                                </select>
                                -->
                            </div>
                            <div class="form-group">
                                <label for=""> وصف المنتج  </label>
                                <textarea class="form-control" name="product_description" id="product_description"></textarea>
                            </div>

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
        <!-- end edit module -->
        <!-- start delete module -->
        <div class="modal" id="modaldemo_delete">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> هل انت متاكد من  حذف  المنتج   </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    @if(isset($product))
                    <form action="{{route('products.destroy',$product->id)}}" method="post">
                        {{method_field('delete')}}
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> اسم المنتج    </label>
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="form-control" name="product_name" id="product_name" value="">
                            </div>
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
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>





    <script>
        $("#modaldemo_edit").on('show.bs.modal',function (event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var product_name = button.data('product_name');
            var section_name = button.data('section_name');
            var product_description = button.data('product_description');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #product_description').val(product_description);
        })
    </script>

    <script>
        $("#modaldemo_delete").on('show.bs.modal',function (event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var product_name = button.data('product_name');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #product_name').val(product_name);
        })
    </script>

@endsection
