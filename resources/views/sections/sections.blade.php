@extends('layouts.master')
@section('title')
    الاقسام
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> الاعدادات  </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <!-- Laravel Validation Messages -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if(session()->has('add'))
        <div class="alert alert-success fade show alert-dismissible">
            <strong> {{session()->get('add')}} </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true"> &times; </span>
            </button>

        </div>
    @endif

    @if(session()->has('edit'))
        <div class="alert alert-success fade show alert-dismissible">
            <strong> {{session()->get('edit')}} </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true"> &times; </span>
            </button>

        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger fade show alert-dismissible">
            <strong> {{session()->get('error')}} </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true"> &times; </span>
            </button>

        </div>
    @endif

    @if(session()->has('delete'))
        <div class="alert alert-danger fade show alert-dismissible">
            <strong> {{session()->get('delete')}} </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true"> &times; </span>
            </button>

        </div>
    @endif

    <!-- row -->
    <div class="row">



            <div class="col-xl-12">

            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="modal-effect btn btn-primary" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">    اضافة قسم جديد <i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap text-center" >
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">  اسم القسم   </th>
                                <th class="border-bottom-0">   الوصف  </th>
                                <th class="border-bottom-0">  العمليات   </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach( $allsections as $section )
                                <?php $i++ ?>

                                <tr>
                                    <td> {{ $i  }} </td>
                                    <td> {{$section->section_name}} </td>
                                    <td> {{$section->description}} </td>
                                    <td>
                                        <a class="modal-effect btn btn-primary" data-id="{{$section->id}}" data-section_name = "{{$section->section_name}}" data-description = {{$section->description}}
                                           data-effect="effect-scale" data-toggle="modal" href="#modaldemo_edit">  <i class="fa fa-pen"></i>  </a>
                                        <a class="modal-effect btn btn-danger" data-effect="effect-scale" data-id= "{{$section->id}}" data-section_name= '{{$section->section_name}}' data-toggle="modal" href="#modaldemo_delete">  <i class="fa fa-trash"></i>   </a>

                                    </td>

                                </tr>

                            @endforeach




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> اضافة قسم   </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('sections.store')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1"> اسم القسم   </label>
                            <input type="text" class="form-control" name="section_name" id="exampleInputEmail1" placeholder=" اسم القسم ">
                        </div>
                        <div class="form-group">
                            <label for=""> وصف القسم </label>
                            <textarea class="form-control" name="description" id="description"></textarea>
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

        <!-- End Modal effects-->

        <!-- start edit module -->
            <div class="modal" id="modaldemo_edit">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title"> تعديل القسم  </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        @if(isset($section))
                        <form action="{{route('sections.update',$section->id)}}" method="post">
                            {{method_field('patch')}}
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"> اسم القسم   </label>
                                    <input type="hidden" name="id" id="id">
                                    <input type="text" class="form-control" name="section_name" id="section_name" placeholder=" اسم القسم ">
                                </div>
                                <div class="form-group">
                                    <label for=""> وصف القسم </label>
                                    <textarea class="form-control" name="description" id="description"></textarea>
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
                            <h6 class="modal-title"> حذف القسم  </h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        @if(isset($section))
                        <form action="{{route('sections.destroy',$section->id)}}" method="post">
                            {{method_field('delete')}}
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id">
                                <h2> هل انت متاكد من حذف القسم </h2>

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
        $("#modaldemo_edit").on('show.bs.modal',function (event){
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var section_name = button.data('section_name');
            var description = button.data('description');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
        })
    </script>

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
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>

@endsection
