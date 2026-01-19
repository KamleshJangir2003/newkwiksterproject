@extends('Agent.common.app')
@section('main')
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">User Profile</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @if(empty($user->image))
							    @if(!empty(session('agent_gender')) && session('agent_gender')==1)
							     <img src="{{asset('Agent/assets/images/avatars/avatar-1.png')}}"alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
							    @else
							     <img src="{{asset('Agent/assets/images/avatars/avatar-2.png')}}"alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
							   @endif
							@else
							<img src="{{asset($user->image)}}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110" height="110">
							@endif
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="lni lni-pencil" style="margin-top: 5px"></i></button>
                            
                                    <div class="mt-3">
                                        <h4>{{session('agent_alise_name')}}</h4>
                                        <p class="text-secondary mb-1">Agent</p>
                                        <p class="text-muted font-size-sm"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <form action="{{route('agent.update_identety_ajent')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{$user->name}}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Alias Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{session('agent_alise_name')}}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{$user->email}}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="{{$user->phone}}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Aadhar Card </h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" class="form-control" name="aadhar" value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Pan Card</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" class="form-control" name="pan" value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Marksheet 10th/12th</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" class="form-control" name="marksheet" value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Resume</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" class="form-control" name="resume" value="" />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
               <!-- Modal -->
										<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
                                                        <form action="{{ route('update_profile_pic') }}" method="post"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <div class="col-sm-3">
                                                                <h6 class="mb-0">profile Picture</h6>
                                                            </div>
                                                            <div class="col-sm-9 text-secondary">
                                                                <input type="file" class="form-control"
                                                                    name="img" required>
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save changes</button>
													</div>
                                                </form>
												</div>
											</div>
										</div>
            </div>
        </div>
    </div>
</div>
<!--end page wrapper -->
@endsection