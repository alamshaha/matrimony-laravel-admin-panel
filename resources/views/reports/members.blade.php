@extends('layouts.matrimony-app')
<style>
    .ti-btn {
        @apply px-4 py-2 rounded-lg text-white font-medium;
    }

    .ti-btn-primary {
        @apply bg-blue-500 hover:bg-blue-700;
    }

    
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}

</style>
@section('content')
    <main class="app-main">
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Reports</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>
                            </ol>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $page_name }} Report</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">

                                    @php $i=0; @endphp
                                    @if ($members)
                                        @foreach ($members as $row)
                                        @php ++$i; @endphp 
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="profile-img">
                                                                <img src="{{ url($row->photo)}}"
                                                                    alt="" />
                                                                {{-- <div class="file btn btn-lg btn-primary">
                                                                    Change Photo
                                                                    <input type="file" name="file" />
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="profile-head">
                                                                <h5>
                                                                   {{$row->name}}
                                                                </h5>
                                                                <p>{{$row->birthdate}}</p>
                                                                <h6> {{$row->about_us}}</h6>
                                                                <h6>
                                                                    {{$row->about_occupations}}                                                                  
                                                                </h6>
                                                                <p class="proile-rating">Package Last Date : <span>  {{$row->last_package_date}} </span></p>
                                                                <p class="proile-rating">View Member Remaining : <span>  {{$row->view_member}} </span></p>
                                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                    <li class="nav-item">
                                                                        <a class="nav-link active" id="home-tab"
                                                                            data-toggle="tab" href="#home{{$i}}" role="tab"
                                                                            aria-controls="home"
                                                                            aria-selected="true">About</a>
                                                                    </li>
                                                                    <li class="nav-item">
                                                                        <a class="nav-link" id="profile-tab"
                                                                            data-toggle="tab" href="#profile{{$i}}" role="tab"
                                                                            aria-controls="profile"
                                                                            aria-selected="false">Timeline</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="submit" class="profile-edit-btn" name="btnAddMore"
                                                                value="Edit Profile" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="profile-work">
                                                                {{-- <p>WORK LINK</p>
                                                                <a href="">Website Link</a><br />
                                                                <a href="">Bootsnipp Profile</a><br />
                                                                <a href="">Bootply Profile</a>
                                                               --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="tab-content profile-tab" id="myTabContent">
                                                                <div class="tab-pane fade show active" id="home{{$i}}"
                                                                    role="tabpanel" aria-labelledby="home-tab">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Member Id</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>{{$row->id}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Name</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>  {{$row->name}}</p>                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Gender</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>  {{$row->gender_name}}</p>                                                                     
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Email</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>  {{$row->email}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Phone</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>  {{$row->mobile}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Profession</label>
                                                                        </div>
                                                                        <div class="col-md-6">                                                                            
                                                                            <p>{{$row->occu_type_name}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Height</label>
                                                                        </div>
                                                                        <div class="col-md-6">                                                                            
                                                                            <p>{{$row->height_name}}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="profile{{$i}}" role="tabpanel"
                                                                    aria-labelledby="profile-tab">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Religion</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>{{$row->religion_name}}</p>
                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Caste Name</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>{{$row->caste_name}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Total Income</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>{{$row->income_name}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Mother Tongue</label>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <p>{{$row->mother_tongue}}</p>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            <hr/>
                                        @endforeach
                                    @endif

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    {{ $members->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                            <!-- /.card -->

                            <!-- /.card -->
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
    </main>
@endsection
