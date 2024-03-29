@extends( 'layouts.app' )

@section('title','')

@section('style')
<!--Data Table-->
        <link href="{{asset('admins/bower_components/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">
        <link href="{{asset('admins/bower_components/datatables-tabletools/css/dataTables.tableTools.css')}}" rel="stylesheet">
        <link href="{{asset('admins/bower_components/datatables-colvis/css/dataTables.colVis.css')}}" rel="stylesheet">
        <link href="{{asset('admins/bower_components/datatables-responsive/css/responsive.dataTables.scss')}}" rel="stylesheet">
        <link href="{{asset('admins/bower_components/datatables-scroller/css/scroller.dataTables.scss')}}" rel="stylesheet">
@endsection

@section('content')
<!--main content start-->
<div id="content" class="ui-content ui-content-aside-overlay">
                <!--page header start-->
                <div class="page-head-wrap">
                    <h4 class="margin0">
                      Edit Import
                    </h4>
                    <div class="breadcrumb-right">
                        <ol class="breadcrumb">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li class="active">Edit Import</li>
                        </ol>
                    </div>
                </div>
                <!--page header end-->

            <div class="ui-content-body">

                <div class="ui-container">
                    <div class="row">
                        <div class="col-sm-12">
                                <section class="panel">
                                    <header class="panel-heading panel-border">
                                       Import 
                                        <span class="tools pull-right">
                                            <a class="refresh-box fa fa-repeat" href="javascript:;"></a>
                                            <a class="collapse-box fa fa-chevron-down" href="javascript:;"></a>
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <form class="cmxform form-horizontal " id="import-form">
                                            {{ csrf_field() }}
                                            @foreach($data[0] as $bl)
                                                <div class="modal-body">
                                                    <div class="form">
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">First Name</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_first_name" name="first_name[]" value="{{$bl->first_name}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Last Name</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_last_name" name="last_name[]" value="{{$bl->last_name}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Email Address</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_email" name="email[]" value="{{$bl->email}}" type="email" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Phone Number</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_phone_number" name="phone_number[]" value="{{$bl->phone_number}}" type="tel" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Country</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_country" name="country[]" value="{{$bl->country}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">State</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_state" name="state[]" value="{{$bl->state}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">City</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_city" name="city[]" value="{{$bl->city}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Address</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_address" name="address[]" value="{{$bl->address}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Gender</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_gender" name="gender[]" value="{{$bl->gender}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="control-label col-lg-3">Marital Status</label>
                                                            <div class="col-lg-9">
                                                                <input class=" form-control" id="edit_marital_status" name="marital_status[]" value="{{$bl->marital_status}}" type="text" required="required"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                @endforeach
                                                <div class="modal-footer">                                                    
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!--main content end-->
@endsection


@section('script')
<script>
    $('#import-form').submit(function(e){
		e.preventDefault();
        $('#import').modal('hide');
            open_loader('#page');

		var form = $("#import-form")[0];
		var _data = new FormData(form);
		$.ajax({
			url: '{{url("/import-edited-data")}}',
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: 'POST',
			success: function(data){
				//$("#blog").modal("toggle");
				if(data.status == "success"){
					toastr.success(data.message, data.status);
                    setTimeout("window.location.href='{{url('/')}}';");
                    close_loader('#page');
                    } else{
                        toastr.error(data.message, data.status);
                        close_loader('#page');
                    }
			},
			error: function(result){
				toastr.error('Check Your Network Connection !!!','Network Error');
                close_loader('#page');
			}
		});
		return false;
    });

</script>
<!--Data Table-->
        <script src="{{asset('admins/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admins/bower_components/datatables-tabletools/js/dataTables.tableTools.js')}}"></script>
        <script src="{{asset('admins/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{asset('admins/bower_components/datatables-colvis/js/dataTables.colVis.js')}}"></script>
        <script src="{{asset('admins/bower_components/datatables-responsive/js/dataTables.responsive.js')}}"></script>
        <script src="{{asset('admins/bower_components/datatables-scroller/js/dataTables.scroller.js')}}"></script>

        <!--init data tables-->
        <script src="{{asset('admins/assets/js/init-datatables.js')}}"></script>

@endsection
