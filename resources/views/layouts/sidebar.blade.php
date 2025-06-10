<?php
    $caste_data = DB::table('castes')
    ->join('religions', 'castes.religion_id', '=', 'religions.id')
    ->select('castes.*', 'religions.name as religion_name') // You can customize the columns
    ->get();

    $gender_data = DB::table('tbl_gender')  
    ->select('tbl_gender.*') // You can customize the columns
    ->get();

?>
<style>
    .hidden
    {
        display: none;
    }
    .bg-body-secondary {
        /* --bs-bg-opacity: 1;
        background-color: rgb(62 104 145) !important; */
    }
</style>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="{{url('')}}" class="brand-link">
                    <!--begin::Brand Image-->
                    <img src="{{ url('public/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text fw-light">Matrimony</span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Dashboard
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('')}}" class="nav-link active">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Dashboard v1</p>
                                    </a>
                                </li>
                               
                            </ul>
                        </li>
                        <li class="nav-header">MATRIMONY APP 1.0.0</li>
                      
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box-seam-fill"></i>
                                <p>
                                    Members
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('report_members')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Memeber Data</p>
                                    </a>
                                </li>
                               
                            </ul>
                        </li>
                       
                      
                        <li class="nav-item hidden">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-pencil-square"></i>
                                <p>
                                    Setup
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('add_users')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_religion')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Religion</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_caste')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Caste</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_gender')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Gender</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_height')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Height</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_marital_status')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Marital Status</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_packages')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Packages</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_occupations')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Occupations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_created_by')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Created By</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('add_income')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Income</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-table"></i>
                                <p>
                                    Reports
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('report_users')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_religions')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Religion</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_caste')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Caste</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_gender')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Gender</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_height')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Height</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_marital_status')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Marital Status</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_packages')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Packages</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_occupations')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Occupations</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_created_by')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Created By</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('report_income')}}" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Income</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        {{-- <li class="nav-header">EXAMPLES</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                    Settings
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                               
                                <li class="nav-item">
                                    <a href="./examples/lockscreen.html" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Lockscreen</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">DOCUMENTATIONS</li>
                        <li class="nav-item">
                            <a href="./docs/introduction.html" class="nav-link">
                                <i class="nav-icon bi bi-download"></i>
                                <p>Installation</p>
                            </a>
                        </li>
                      
                     
                        <li class="nav-item">
                            <a href="./docs/license.html" class="nav-link">
                                <i class="nav-icon bi bi-patch-check-fill"></i>
                                <p>License</p>
                            </a>
                        </li> --}}
                        <li class="nav-header">CASTEWISE MEMBERS</li>
                        @if($caste_data)
                        @foreach ($caste_data as $row)         
                        <li class="nav-item">
                            <a href='{{ url("castewise_data/$row->id")}}' class="nav-link">
                                <i class="nav-icon bi bi-circle-fill"></i>
                                <p>{{$row->religion_name}} - {{$row->name}}</p>
                            </a>
                        </li>
                        @endforeach
                        @endif
                        <li class="nav-header">GENDER</li>
                        @if($gender_data)
                        @foreach ($gender_data as $row)  
                        <li class="nav-item">
                            <a href="{{ url("genderwise_data/$row->id")}}" class="nav-link">
                                <i class="nav-icon bi bi-circle text-danger"></i>
                                <p class="text">{{$row->name}}</p>
                            </a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <!--end::Sidebar Menu-->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>