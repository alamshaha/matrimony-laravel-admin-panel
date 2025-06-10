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
                        <div class="col-sm-6">
                            <h3 class="mb-0">Form</h3>
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
                                    <h3 class="card-title">{{ $page_name }} Form</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <!--begin::Quick Example-->
                                        <div class="card card-primary card-outline mb-4">
                                            <!--begin::Header-->
                                            {{-- <div class="card-header"><div class="card-title">Quick Example</div></div> --}}
                                            <!--end::Header-->
                                            <!--begin::Form-->
                                            <form id="caste_form">
                                                @csrf
                                                <input type="hidden" name="type" class="form-control" id="type" value="1">
                                                <input type="hidden" name="id" class="form-control" id="id"  value="{{$caste_data[0]->id}}">
                                                <!--begin::Body-->
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label for="validationCustom04" class="form-label">Religion name</label>
                                                        <select class="form-select" id="validationCustom04" required="" name="religion_id">
                                                            @if($religion_data)
                                                            @foreach ($religion_data  as $row)
                                                                @if($row->id == $caste_data[0]->religion_id)
                                                                <option selected="" name="religion_id"  value="{{$row->id}}">{{$row->name}}</option>
                                                                @else 
                                                                <option name="religion_id"   value="{{$row->id}}">{{$row->name}}</option>
                                                                @endif

                                                            @endforeach
                                                            @endif
                                                        
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="validationCustom04" class="form-label">Caste name</label>
                                                        <input type="text" class="form-control" id="caste" name="name" value="{{$caste_data[0]->name}}"
                                                           >

                                                    </div>
                                                  
                                                </div>
                                                <!--end::Body-->
                                                <!--begin::Footer-->
                                                <div class="card-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                                <!--end::Footer-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Quick Example-->
                                        <!--begin::Input Group-->

                                        <!--end::Input Group-->
                                        <!--begin::Horizontal Form-->

                                        <!--end::Horizontal Form-->
                                    </div>
                                </div>
                                <!-- /.card-body -->

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
    <script>
      
        $(document).ready(function() 
       {
       
              $(".btn-success").on('click',function(){
                  alert("Done");
               });
       
       
           $("#caste_form").submit(function (event) {
           var keyCode = event.keyCode || event.which; 
              
             event.preventDefault();
             var action = $('#caste_form').attr('action');    
             //var formData = $("#config_form").serialize();   
               var keyCode = event.keyCode || event.which; 
              
             var formData = new FormData($(this)[0]);
                     $.ajax({                 
                         type:'post',
                         url:'{{url('save_edit_castes')}}',
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
@endsection
