@extends('backend.common.layout')
@section('content')
    <div class="row">
        <form action="{{route('store.text')}}" method="POST">
            @csrf
            <div class="col-xxl-12">
                <div class="card border card-border-info">
                    <div class="card-header">
                        <h6 class="card-title fw-bold">Text Script
                            {{-- <span class="badge bg-info align-middle fs-10">In Process</span> --}}
                        </h6>
                    </div>
                    <textarea class="card-body h-100" id="editor" name="text">{{$text->text ?? ''}}</textarea>
                </div>
            </div>
            <div class="col-xxl-12">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
