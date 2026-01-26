@extends('Agent.common.app')
@section('main')
<div class="page-wrapper">
  <div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Training</div>
      <div class="ps-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">materials</li>
          </ol>
        </nav>
      </div>
    </div>
    <!--end breadcrumb-->
    @if(!empty($datas))
   
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Scripts & Files</h5>
        <hr/>
        @foreach ($datas as $data)
        
    <div class="accordion accordion-flush" id="accordionFlushExample{{$data->id}}">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-heading{{$data->id}}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$data->id}}" aria-expanded="false" aria-controls="flush-collapse{{$data->id}}" style="margin-bottom:10px">
                    {{$data->heading}}
                </button>
            </h2>
            <div id="flush-collapse{{$data->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$data->id}}" data-bs-parent="#accordionFlushExample{{$data->id}}">
              @if(!empty($data->message))
              <div class="accordion-body">
                   {{!! $data->message !!}}
                </div>
                @endif
                @if(!empty($data->image))
                <a href="{{ asset($data->image) }}" target="_blank" style="padding:5px 25px;background-color:#74ba07;margin:10px;color:white;font-size:20px">File</a>
                @endif
            </div>
        </div>
    </div>
    <hr style="margin: 1px">
@endforeach
      </div>
    </div>  
   
    @endif
  </div>
  <!--end page content -->
</div>
@endsection