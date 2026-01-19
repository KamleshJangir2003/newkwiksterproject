@extends('Agent.common.app')
@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="leadsList">
                                <div class="card-header border-0">
                                <form action="{{route('agent.store_credential')}}" method="post">
                                 @csrf
                                 <input type="hidden" name="id" value="{{session('agent_id')}}"> 
                                    <div class="row g-4 align-items-center">
                                        <div class="col-sm-3">
                                            <div class="search-box">
                                                <input type="text" name="platform" class="form-control search" placeholder="Enter Platform Name" required>
                                               
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="search-box">
                                                <input type="text" name="username" class="form-control search" placeholder="Enter Username" required>
                                               
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <div class="search-box" >
                                                <input type="text" name="password" class="form-control search" placeholder="Enter password" required>
                                               
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="search-box">
                                                <input type="text" name="link" class="form-control search" placeholder="Paste Link" required>
                                              
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="search-box">
                                                <input type="submit" class="btn btn-primary w-100" placeholder="Save">
                                             
                                            </div>
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
                                                            <th scope="col">Platform Name</th>
                                                            <th scope="col">Username</th>
                                                            <th scope="col">Password</th>
                                                            <th scope="col">Link</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($credentials))
                                                            @php $a = 0; @endphp
                                                            @foreach ($credentials as $credential)
                                                                @php $a++; @endphp
                                                                <tr>
                                                                    <th scope="row">{{ $a }}</th>
                                                                    <td>{{ $credential->platform }}</td>
                                                                    <td>{{ $credential->username }}</td>
                                                                    <td>{{ $credential->password }}</td>
                                                                    <td><a href="{{ $credential->link }}" target="_blank">{{ $credential->link }}</a></td>
                                                                    <td><button class="red-button" onclick="window.location.href='{{ route('delete_credentials', base64_encode($credential->id)) }}'">Delete</button></td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{$credentials->links()}}
                                            </div>
                                        </div>
            
                                </div>
                            </div>
            
                        </div>
                        <!--end col-->
                    </div>

                </div> 
            </div>
        </div>
    </div>
@endsection
