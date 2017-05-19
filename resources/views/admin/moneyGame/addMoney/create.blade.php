@extends('layouts.master')
@section('title')
    Tạo Add Money
@endsection
@section('content')

    <!-- /section:settings.box -->
    <div class="page-header">
        <h1>
            Form Elements
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Common form elements and layouts
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <!-- PAGE CONTENT BEGINS -->
            {!! Form::open(array('route' => 'addMoney.store','method'=>'POST', 'class' => 'form-horizontal', 'id' => 'formSubmit')) !!}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">User Id</label>
                <div class="col-sm-9 input-icon input-icon-right">
                    <input type="text" class="form-control" id="userId" name="userId"/>
                    {{--<span id="name_status" class="alert-danger"></span>--}}
                    <input type="hidden" name="userIdHidden" id="userIdHidden">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Cộng Mon</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="form-field-8" name="addCash" />
                </div>
            </div>

            {{--<div class="form-group">--}}
                {{--<label class="col-sm-3 control-label no-padding-right" for="form-field-8">Cộng xu</label>--}}
                {{--<div class="col-sm-9">--}}
                    {{--<input type="text" class="form-control" id="form-field-8" name="addGold" />--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-8">Mô tả</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="form-field-8" name="description"></textarea>
                </div>
            </div>


            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>

            <div class="hr hr-24"></div>

            {!! Form::close() !!}

        </div><!-- /.col -->
    </div><!-- /.row -->
    <script type="text/javascript">

        function checkname()
        {
            var name=document.getElementById( "userId" ).value;

            if(name)
            {
                $.ajax({
                    dataType: 'json',
                    url: '/checkUser',
                    data: {
                        userID:name
                    },
                    success: function (response) {
                        $('#userId').next('i').remove();
                        if(response.status == 'OK'){
                            $('#userId').after('<i class="ace-icon fa fa-check green" style="right:15px"></i>');
//                            $('#userIdHidden').val(1);
                        } else {
                            $('#userId').after('<i class="ace-icon fa fa-close red" style="right:15px"></i>');
//                            $('#userIdHidden').val(0);
                        }
                    }
                });
            }
            else
            {
                $('#userId').next('i').remove();
                return false;
            }
        }

//        function checkUser()
//        {
//            var userIdHidden=document.getElementById( "userIdHidden" ).value;
//
//            if(userIdHidden == 0)
//            {
//                alert('User không tồn tại');
//                return false;
//            }
//            else
//            {
//                document.getElementById("formSubmit").submit();
//            }
//        }

    </script>

@endsection