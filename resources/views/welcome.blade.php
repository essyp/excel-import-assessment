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
                       Data Import History
                    </h4>
                    <div class="breadcrumb-right">
                        <ol class="breadcrumb">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li class="active">Data Import History</li>
                        </ol>
                    </div>
                </div>
                <!--page header end-->

            <div class="ui-content-body">

                <div class="ui-container">
                    <div class="row">
                    <form id="status_form" action='{{url("bulk-action")}}' method="POST">
                        {{ csrf_field() }}
                        <div class="col-sm-12">
                            <div class="mbot-20">
                                    <div class="btn-group">
                                       <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                        <ul role="menu" class="dropdown-menu">
                                            <li><button class="btn btn-danger" name="submit" type="button" onclick="status_form('delete')">Delete</button></li>
                                        </ul>
                                    </div>
                                    <button type="button" data-toggle="modal" data-target="#import" class="btn btn-default">Import New Data</button>
                                    <button type="button" data-toggle="modal" data-target="#import-edit" class="btn btn-default">Import & Edit</button>
                                    <a type="button" href="{{url('download-template')}}" class="btn btn-default">Download Template</a>
                                </div>
                                <section class="panel">
                                    <header class="panel-heading panel-border">
                                       Import History
                                        <span class="tools pull-right">
                                            <a class="refresh-box fa fa-repeat" href="javascript:;"></a>
                                            <a class="collapse-box fa fa-chevron-down" href="javascript:;"></a>
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <table id="datatable" class="table responsive-data-table table-striped">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" onClick="checkAllContestant()" id="chAllCon" /></th>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Location</th>
                                                <th>Address</th>
                                                <th>Gender</th>
                                                <th>Marital Status</th>
                                                <th>Created At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $bl)
                                            <tr>
                                                <td><input class="contestantBox" type="checkbox" name="id[]" value="{{$bl->id}}" /> </td>
                                                <td>{{$bl->ref_id}}</td>
                                                <td>{{$bl->first_name}} {{$bl->last_name}}</td>
                                                <td>{{$bl->email}}</td>
                                                <td>{{$bl->phone_number}}</td>
                                                <td>{{$bl->city?$bl->city.',':''}} {{$bl->state?$bl->state.',':''}} {{$bl->country?$bl->country.',':''}}</td>
                                                <td>{{$bl->address}}</td>
                                                <td>{{$bl->gender}}</td>
                                                <td>{{$bl->marital_status}}</td>
                                                <td>{{$bl->created_at}}</td>                                                
                                                <td>
                                                    @if($bl->status==1)
                                                    <span class="label label-success">active</span>
                                                    @else
                                                    <span class="label label-warning">inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <li><a href="javascript:void(0);" style="color: blue" onclick="update({{$bl}})">Update</a></li>
                                                    </ul>
                                                </div>
                                                </td>
                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>

                    </div>


                </div>
            </div>
            <!--main content end-->
@endsection


<!-- Button trigger modal -->
<div  id="import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Import New Data</h4>
            </div>
            <form class="cmxform form-horizontal " id="import-form">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form">

                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Choose File</label>
                            <div class="col-lg-9">
                                <input class=" form-control" name="import_file" type="file" required="required"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Button import and edit modal -->
<div  id="import-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Import New Data</h4>
            </div>
            <form class="cmxform form-horizontal" action="{{url('import/edit')}}" enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form">

                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Choose File</label>
                            <div class="col-lg-9">
                                <input class=" form-control" name="import_file" type="file" required="required"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Button edit modal -->
<div  id="editmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Data</h4>
            </div>
            <form class="cmxform form-horizontal " id="edit-form">
            {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">First Name</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_first_name" name="first_name" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Last Name</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_last_name" name="last_name" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Email Address</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_email" name="email" type="email" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Phone Number</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_phone_number" name="phone_number" type="tel" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Country</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_country" name="country" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">State</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_state" name="state" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">City</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_city" name="city" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Address</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_address" name="address" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Gender</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_gender" name="gender" type="text" required="required"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-lg-3">Marital Status</label>
                            <div class="col-lg-9">
                                <input class=" form-control" id="edit_marital_status" name="marital_status" type="text" required="required"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input class=" form-control" id="edit_id" name="id" type="hidden" required="required"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>




@section('script')
<script>
    $('#import-form').submit(function(e){
		e.preventDefault();
        $('#import').modal('hide');
            open_loader('#page');

		var form = $("#import-form")[0];
		var _data = new FormData(form);
		$.ajax({
			url: '{{url("/import")}}',
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: 'POST',
			success: function(data){
				//$("#blog").modal("toggle");
				if(data.status == "success"){
					toastr.success(data.message, data.status);
                    $( "#datatable" ).load( "{{url('/')}} #datatable" );
                    // window.setTimeout(function(){location.reload();},2000);
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

    function status_form(value) {
        open_loader('#page');

		var form = document.getElementById('status_form');
        var _data = new FormData(form);
        _data.append('submit',value);

		$.ajax({
			url: form.action,
			data: _data,
			enctype: 'multipart/form-data',
			processData: false,
			contentType:false,
			type: form.method,
			success: function(data){
				//$("#blog").modal("toggle");
				if(data.status == "success"){
                    toastr.success(data.message, data.status);
                    $( "#datatable" ).load( "{{url('/')}} #datatable" );
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
    }

    function update(event){
        //$('#modaltitle').text("Update " +event.title)
        $('#edit_first_name').val(event.first_name)
        $('#edit_last_name').val(event.last_name)
        $('#edit_email').val(event.email)
        $('#edit_phone_number').val(event.phone_number)
        $('#edit_country').val(event.country)
        $('#edit_state').val(event.state)
        $('#edit_city').val(event.city)
        $('#edit_address').val(event.address)
        $('#edit_gender').val(event.gender)
        $('#edit_marital_status').val(event.marital_status)
        $('#edit_id').val(event.id)
        $('#editmodal').modal('show')
    }

    $('#edit-form').submit(function(e){
        e.preventDefault();
        $('#editmodal').modal('hide');
            open_loader('#page');

        var form = $("#edit-form")[0];
        var _data = new FormData(form);
        $.ajax({
            url: '{{url("update-data")}}',
            data: _data,
            enctype: 'multipart/form-data',
            processData: false,
            contentType:false,
            type: 'POST',
            success: function(data){
                //$("#service").modal("toggle");
                if(data.status == "success"){
                    toastr.success(data.message);
                    $( "#datatable" ).load( "{{url('/')}} #datatable" );
                    close_loader('#page');
                    } else{
                        toastr.error(data.message);
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

    function checkAllContestant(){
    var ch =document.getElementById('chAllCon').checked,
    checked = false;
    if(ch){
        checked=true;
    }
        var els = document.getElementsByClassName('contestantBox');

        for(var g=0;g<els.length;g++){
            els[g].checked=checked;
        }


    }

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
