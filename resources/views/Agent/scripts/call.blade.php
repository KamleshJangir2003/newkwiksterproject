@extends('Agent.common.app')
@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">

                    <div class="col-12">
                        <div class="card m-b-20">
                            <form action="{{ route('store_all_script') }}" method="post">
                                @csrf
                                <h4 style="text-align: center">Call Script</h4>
                                <textarea class="form-control" height="500px" type="text" name="calling" id="editor">{{ old('name') ? old('name') : $script->calling_script ?? '' }}</textarea>

                                <div class="form-group" style="margin-left:17px">
                                    <div class="w-100 text-center">
                                        <button type="submit" style="margin-top: 20px;" class="btn btn-danger"><i
                                                class="fa fa-user"></i>
                                            Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
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
