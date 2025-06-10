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
                  <div class="card-header"><h3 class="card-title">{{$page_name}}  Report</h3>
                    <button style="float:right" type="button" class="btn btn-primary btn-md " data-toggle="modal" data-target="#modal-default">Add Created By</button>
               
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Name</th>
                          <th>Action</th>
                       
                        </tr>
                      </thead>
                      <tbody>
                        @php $i=0; @endphp
                        @if($created_by)
                        @foreach ($created_by as $row)
                       
                   
                        <tr class="align-middle">
                          <td>{{++$i}}</td>
                          <td> {{ $row->name }}</td>
                          <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" onClick="edit_modal(<?php echo  $row->id;?>,'<?php echo  $row->name;?>')"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger delete_records" onClick="handleDelete('tbl_created_by','id','<?php echo  $row->id;?>')"><i class="fa fa-trash"></i></button>
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
                    {{ $created_by->links('pagination::bootstrap-4') }}
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
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Created By</h4>
          <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>          
        <div class="modal-body">
        <form action="" id="created_by_form" name="created_by_form" method="POST">
          @csrf
          <div class="form-group">
            <label for="text">Created By Name</label>
            <input type="hidden" name="type" class="form-control" id="type" value="0">
            <input type="hidden" name="id" class="form-control" id="id"  value="0">
            <input type="text" name="name" class="form-control" id="name">
          </div>
      
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary ">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <script>
    function edit_modal(id,name)
    {     
         $("#type").val(1);
         $("#id").val(id);
         $("#name").val(name);
    }
    $(document).ready(function() 
   {
   
          $(".btn-success").on('click',function(){
              alert("Done");
           });
   
   
       $("#created_by_form").submit(function (event) {
       var keyCode = event.keyCode || event.which; 
          
         event.preventDefault();
         var action = $('#created_by_form').attr('action');    
         //var formData = $("#config_form").serialize();   
           var keyCode = event.keyCode || event.which; 
          
         var formData = new FormData($(this)[0]);
                 $.ajax({                 
                     type:'post',
                     url:'{{url('save_created_by')}}',
                     data:formData,
                     async: false,
                       cache: false,
                       contentType: false,
                       enctype: 'multipart/form-data',
                       processData: false,
                     beforeSend:function(){                                   
                     },
                     complete:function(){
                                   
                     },
                     success:function(result){                   
                             $('input').removeClass("!border-danger"); 
                         
                                var myObj = JSON.parse(result);              
                                if(myObj.status=='success')
                                {                                     
                                   swal_message('Success',myObj.success_message,"success"); 
                                }   
                                else if(myObj.status=='failed')
                                {                                     
                                   swal_message('Info',myObj.success_message,"warning"); 
                                }  
                                else
                                {
                                   $.each(myObj.response, function(key,value) {
                                     swal_message('Info',value,'info');
                                   });   
                                }  
                     },
                     error: function (xhr) {
                            
                            $('input').removeClass("!border-danger"); 
                             $.each(xhr.responseJSON.errors, function(key,value) {
                                 $('#'+key).addClass("!border-danger"); 
                                 swal_message('Info',value,'info');
                             }); 
                          }
                 });
         
       });
     });
     </script>

    
     </script>
@endsection
