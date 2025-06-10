@extends('layouts.matrimony-app')
<style>
    .ti-btn {
    @apply px-4 py-2 rounded-lg text-white font-medium;
}

.ti-btn-primary {
    @apply bg-blue-500 hover:bg-blue-700;
}
</style>

@section('content')

<?php

$data_url = array("report_members","report_users","report_religions","report_caste","report_gender","report_height","report_marital_status","report_packages","report_occupations","report_created_by","report_income");
$title_array = array("Members","Users","Religions","Castes","Gender","Height","Mariatl Status","Packages","Occupations","Created by","Income Slab");

$color_array = array("primary","warning","info","danger","danger","primary","warning","info","info","danger","primary","warning");

?>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
          <!--begin::Col-->
          
       
          @if($data)
         <?php $i= 0;?>
          @foreach($data as $row)
          <!--end::Col-->
          <div class="col-lg-3 col-6">
            <!--begin::Small Box Widget 1-->
            <div class="small-box text-bg-<?php echo $color_array[$i];?>">
              <div class="inner">
                <h3><?php echo $row;?></h3>
                <p><?php echo $title_array[$i];?></p>
              </div>
              <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
              </svg>
              <a
                href="<?php echo $data_url[$i];?>"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
              >
                More info <i class="bi bi-link-45deg"></i>
              </a>
            </div>
      
            <!--end::Small Box Widget 1-->
          </div>
        <?php ++$i;?>
          @endforeach
          @endif
        </div>
        <!--end::Row-->
        <!--begin::Row-->
     
        <!-- /.row (main row) -->
      </div>
      <!--end::Container-->
    </div>
    <!--end::App Content-->
  </main>
@endsection
