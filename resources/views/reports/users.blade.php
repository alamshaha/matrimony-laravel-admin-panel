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
<main class="app-main">
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Reports</h3></div>
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
                  <div class="card-header"><h3 class="card-title">{{$page_name}} Report</h3></div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Action</th>
                       
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=0; @endphp
                        @if($users)
                        @foreach ($users as $row)
                       
                   
                        <tr class="align-middle">
                          <td>{{++$i}}</td>
                          <td> {{ $row->name }}</td>
                          <td> {{ $row->email }}</td>
                          <td> {{ $row->mobile }}</td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                              </div>

                          </td>
                        </tr>
                        @endforeach
                        @endif
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">                  
                    {{ $users->links('pagination::bootstrap-4') }}
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
