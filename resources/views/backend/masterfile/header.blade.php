<!-- Nav Start -->
<nav class="navbar navbar-expand-custom navbar-mainbg">
    <a class="navbar-brand navbar-logo text-white" href="#">Welcome {{ auth()->user()->name }} to MasterFile
        Dashboard 🐱‍🏍</a>
    <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <div class="hori-selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
             @if (auth()->user()->designation == 'Admin' || auth()->user()->designation == 'Manager')
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/kwikster/masterfile')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
            </li>
            @endif
            @if (auth()->user()->designation == 'Admin' || auth()->user()->designation == 'Manager')
             <li class="nav-item ">
                <a class="nav-link" href="{{url('kwikster/masterfile/excel-view')}}"><i class="fas fa-tachometer-alt"></i>Excel View</a>
            </li>
            @endif
           
            @if (auth()->user()->designation == 'Admin' || auth()->user()->designation == 'Manager')
            <li class="nav-item ">
                <a class="nav-link" href="javascript:void(0);" data-toggle="modal" data-target="#form"><i
                        class="far fa-address-book"></i>Upload</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{url('delete/duplicate/masterfile/data')}}" onclick="return confirm('Are you sure,You want to delete Duplicate Data ?')"><i
                        class="fa-regular fa-clone"></i>Duplicate</a>
            </li>
            @endif
            @if (auth()->user()->designation == 'Admin' || auth()->user()->designation == 'Manager')
             <li class="nav-item ">
                <a class="nav-link" href="{{url('delete/dnd/masterfile/data')}}"><i class="fas fa-power-off"></i>Delete DND Data</a>
            </li>
            @endif
            @if (auth()->user()->designation == 'Admin')
            <li class="nav-item ">
                <a class="nav-link" href="{{url('delete/all/masterfile/data')}}" onclick="return confirm('Are you sure,You want to delete All Unassigned Data ?')"><i
                        class="fa-regular fa-trash-can"></i>Delete All</a>
            </li>
            @endif
        </ul>
    </div>
</nav>
<!-- Nav End -->
