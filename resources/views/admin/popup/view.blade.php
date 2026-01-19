@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Training Materials</h5>
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
                        <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20" style="padding:20px">
                                        <form action="{{ route('store_Training_metarial') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-floating" style="margin-bottom: 10px;width:150px">
                                                <input type="text" class="form-control" type="text"
                                                    value="" id="" name="heading"
                                                    placeholder="Enter heading" required>
                                            </div>
                                            <textarea class="form-control" type="text" name="message" id="editor">{{ old('name') ? old('name') : $script->email_script ?? '' }}</textarea>
                                            
                                            <input type="file" name="img" style="margin-top:20px ">

                                            <div class="form-group" style="margin-left:17px">

                                                <div class="w-100 text-center">
                                                    <button type="submit" style="margin-top: 20px;"
                                                        class="btn btn-danger"><i class="fa fa-user"></i>
                                                        Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
        
                                            <table  class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.No.</th>
                                                        <th scope="col">Script</th>
                                                        <th scope="col">File</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($datas))
                                                        @php $a = 0; @endphp
                                                        @foreach ($datas as $data)
                                                            @php $a++; @endphp
                                                            <tr>
                                                                <th scope="row">{{ $a }}</th>
                                                                <td><textarea>{{ $data->message }}</textarea></td>
                                                                <td>
                                                                    <a href="{{ asset($data->image) }}" target="_blank">Open File</a>
                                                                </td>
                                                                <td><button class="red-button" onclick="window.location.href='{{ route('delete_Training_metarial', base64_encode($data->id)) }}'">Delete</button></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                           
                                        </div>
                                    </div>
        
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
                .create(document.querySelector('#editor'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endsection
