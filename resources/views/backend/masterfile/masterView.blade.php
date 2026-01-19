@extends('backend.masterfile.layout')
@section('css')
   
   <style>
.cards-list {
  z-index: 0;
  width: 100%;
  display: flex;
  flex-wrap: wrap;
}

.card {
  margin: 30px;
  width: 250px;
  height: 110px;
  cursor: pointer;
  transition: 0.4s;
}

.card .card_image {
  width: inherit;
  height: inherit;
  border-radius: 40px;
}

.card .card_image img {
  width: inherit;
  height: inherit;
  object-fit: cover;
}

.card .card_title1 {
  text-align: center;
  border-radius: 0px 0px 40px 40px;
  font-family: sans-serif;
  font-weight: bold;
  font-size: 30px;
  height: 40px;
  display:none;
}



.card:hover {
  transform: scale(1.1, 1.1);
  
}
.card:hover .card_title1 {
  display: block;
}
.delbtn:hover {
    border:1px solid red;
  background:red;
  color:white;
}
.viewbtn:hover {
  background:#405189;
  color:white;
}
.title-white {
  color: white;
}

.title-black {
  color: black;
}

@media all and (max-width: 500px) {
  .card-list {
    /* On small screens, we are no longer using row direction but column */
    flex-direction: column;
  }
}

.viewbtn{
        border: 1px solid #405189;
    background: white;
    width:45%;
    color:#405189;
     height: 37px;
}
.delbtn{
     background: white;
    border: 1px solid #405189;
    color: #405189;
    width:45%;
    height: 37px;
    margin-left: 2px;
}
.content{
    position: absolute;
        padding: 20px 20px;
        color:white;
}
   </style>
    
@endsection
@section('content')
<div class="cards-list">
   @foreach($excelData as $batchName => $data)
  <div class="card 3">
    <div class="card_image">
      <img src="{{ asset('/assets/images/bback.jpg') }}" />
    </div>
    <p class="content">
      File Name : {{ $batchName }}
      <br>
      Data : {{ count($data) }}
      <br>
      Date : {{ $data[0]->created_at }}
    </p>
    <div class="card_title1">
      <p><a href="{{url('kwikster/masterfile/view/'.$batchName)}}"><span class="btn viewbtn">View</span></a>
       @if (auth()->user()->designation == 'Admin')
      <a href="{{url('delete/masterfile/batch/'.$batchName)}}"><span class="delbtn btn">Delete</span></a>
      @endif</p>
    </div>
  </div>
  @endforeach
  
</div>
@endsection
@section('js')
   
    
@endsection
