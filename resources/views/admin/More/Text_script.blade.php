@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Text script</h5>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">

                           <h4>Text Script</h4>
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">

                                            <form action="{{route('store_script')}}" method="post">
                                                @csrf

                                                    <textarea class="form-control" type="text" name="text" id="editor">{{old('name') ? old('name') : $script->text_script ??''}}</textarea>

                                            <div class="form-group" style="margin-left:17px">

                                                    <input type="hidden" name="id" value="{{session('admin_id')}}">
                                                <div class="w-100 text-center">
                                                    <button type="submit" style="margin-top: 20px;"
                                                        class="btn btn-danger"><i class="fa fa-user"></i>
                                                        Submit</button>
                                                </div>

                                            </div>
                                        </form>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                        </div>
                   
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>
        <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                    .create( document.querySelector( '#editor' ) )
                    .then( editor => {
                            console.log( editor );
                    } )
                    .catch( error => {
                            console.error( error );
                    } );
    </script>
    @endsection
