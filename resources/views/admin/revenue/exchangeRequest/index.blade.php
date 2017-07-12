@extends('layouts.master')
@section('title')
    Chi tiết giao dịch đổi thưởng
@endsection
@section('content')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div id="container"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Tìm kiếm</h4>

                        <span class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </span>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            {!! Form::open(['method'=>'GET','url'=>'revenue/exchangeRequest','role'=>'search', 'name' => 'formSearch'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">UserID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên hiển thị</label>
                                    <input class="form-control" name="displayName" type="text" value="{{request('displayName')}}"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian đổi thẻ</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timeRequest" id="id-date-range-picker-1" value="{{request('timeRequest') ? request('timeRequest') : get7Day()}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                @permission(['administrator','admin'])
                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Đối tác</label>
                                    {!! Form::select('partner', $partner, request('partner'), ['class' => 'form-control', 'id' => "partner"]) !!}

                                </div>
                                @endpermission

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Trạng thái</label>
                                    {!! Form::select('status', $statusArr, request('status'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>


                            </div>

                            {!! Form::close() !!}
                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" id="search_button" onclick="document.formSearch.submit();" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="{{ route('exchangeRequest.excel', ['userId' => request('userId'),'userName' => request('userName'),'displayName' => request('displayName'), 'timeRequest' => request('timeRequest'), 'phone' => request('phone'), 'status' => request('status')]) }}">
                                        <button class="btn btn-info btn-sm">
                                            Download Excel
                                        </button>
                                    </a>
                                </div>
                            </div>
                            {{--</form>--}}

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
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
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="hidden-480">STT</th>
                            <th class="hidden-480">User ID</th>
                            <th class="hidden-480">Tên hiển thị</th>
                            <th>Tên đăng nhập</th>
                            <th class="hidden-480">Tổng tiền đã nạp</th>
                            <th>Total cash</th>
                            <th>Giá trị thẻ</th>
                            <th>Seri thẻ</th>
                            <th>Trạng thái</th>
                            <th class="hidden-480">Exchange By</th>
                            <th>Thống kê</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian tạo</th>
                            <th class="hidden-480">Tên Admin</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr @if($rs->status === 5) style="background-color:#3a87ad; color: white" @endif >
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $rs->requestUserId }}</td>
                                <td class="hidden-480">{{ $rs->displayName }}</td>
                                <td>{{ $rs->requestUserName }}</td>
                                <td class="hidden-480">{{ number_format($rs->totalMoneyCharged) }}</td>
                                <td>{{ number_format($rs->totalCash) }}</td>
                                <td>{{ number_format($rs->totalParValue) }}</td>
                                <td>{{ getSerial($rs->responseData) }}</td>
                                <td>
                                    @if($rs->status === 3)
                                        <span class="label label-info arrowed-right arrowed-in">Waiting</span>
                                    @elseif($rs->status === 1)
                                        <span class="label label-success arrowed-in arrowed-in-right">Success</span>
                                    @elseif($rs->status === -1)
                                        <span class="label arrowed">Reject</span>
                                    @elseif($rs->status === 2)
                                        <span class="label label-danger arrowed">Fail</span>
                                    @elseif($rs->status === 5)
                                        <span class="label label-danger arrowed">Checking</span>
                                    @endif
                                </td>
                                <td class="hidden-480" style="text-align: center">
                                    @if($rs->description == null) <span class="label label-sm label-success"><i class="ace-icon fa fa-check bigger-120"></i></span> @else <i class="ace-icon fa fa-hand-o-right icon-animated-hand-pointer blue"></i> @endif
                                </td>
                                <td><a href="#modal-table" role="button" class="green" data-toggle="modal" data-id="{{$rs->requestUserId}}"> <span class="ace-icon fa fa-signal"></span> </a></td>
                                <td class="hidden-480">{{ $rs->created_at }}</td>
                                <td class="hidden-480">{{ getAdminName($rs->admin_id) }}</td>
                                <td>
                                    {{--[{"provider":"VTT","amount":20000,"serial":"58122200912","pin":"6567138553863"}]--}}
                                    {{--[{"provider":"VTT","amount":20000,"serial":"58122218834","pin":"6567755011893"}]--}}
                                    @permission(['administrator','admin'])
                                    {!! Form::open(['method' => 'PATCH','route' => ['exchangeRequest.update', $rs->requestId],'style'=>'display:inline', 'onsubmit' => 'return confirm("Are you sure?");']) !!}
                                    @if($rs->status == 5)
                                        <button class="btn btn-xs btn-info" name="reload" type="submit" value="reload" title="Duyệt lại">
                                            <i class="ace-icon fa fa-refresh white"></i>
                                        </button>
                                        <button class="btn btn-xs btn-danger" type="button" data-id = "{{$rs->requestId}}" data-type="2" data-toggle="modal" data-target="#deleteModal" title="Từ chối">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </button>
                                    @elseif($rs->status == 3)
                                        <button class="btn btn-xs btn-info" name="reload" type="submit" value="reload" title="Duyệt lại">
                                            <i class="ace-icon fa fa-refresh white"></i>
                                        </button>
                                        <button class="btn btn-xs btn-danger" type="button" data-id = "{{$rs->requestId}}" data-type="2" data-toggle="modal" data-target="#deleteModal" title="Từ chối">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </button>
                                        <button class="btn btn-xs btn-warning" name="checking" type="submit" value="checking" title="Checking">
                                            <i class="ace-icon fa fa-share white"></i>
                                        </button>
                                    @endif
                                    {!! Form::close() !!}
                                    @endpermission

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->
                @include('layouts.partials._pagination')
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteModalLabel">Update Exchange Request</h4>
                </div>
                <div class="modal-body">
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
                    {{ Form::open(array('url'=>'revenue/exchangeRequest/delete','class'=>'form-horizontal', 'method'=> 'POST', 'id' => 'formSubmit')) }}
                    {!! csrf_field() !!}
                    <input type="hidden" name="exchangeId" class="id" id="exchangeId">
                    <input type="hidden" name="type" class="id" id="type">
                    <div class="form-group">
                        <label for="description" class="control-label">Nhập lý do:</label>
                        <textarea class="form-control" id="des" name="description"></textarea>
                        {{--<input class="form-control" type="text" id="des" name="description">--}}
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="checkRequired()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-table" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width: 768px">
            <div class="modal-content">
                <div class="modal-header no-padding">
                    <div class="table-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="white">&times;</span>
                        </button>
                        Thống kê ván chơi của User ID <span id="requestUserId"></span>
                    </div>
                </div>

                <div id="table-wrapper">
                    <div class="modal-body modal-statistic no-padding" id = "table-scroll">


                    </div>

                </div>

                <div class="modal-footer no-margin-top">
                    <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Close
                    </button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- PAGE CONTENT ENDS -->

    <script>
        jQuery(function($) {

            //or change it into a date range picker
            $('.input-daterange').datepicker({autoclose:true});


            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=timeRequest]').daterangepicker({
                'applyClass' : 'btn-sm btn-success',
                'cancelClass' : 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                }
            })
                .prev().on(ace.click_event, function(){
                $(this).next().focus();
            });

        });
    </script>
    <script type="text/javascript">
        <?php if($purchase_arr != null):?>
        $(function () {
            var array_date = new Array();
            var sum_money = new Array();
            <?php foreach($purchase_arr as $day => $value):?>
                array_date.push(['<?php echo $day;  ?>']);
            sum_money.push(<?php echo isset($value)? $value : 0  ?>);
            <?php endforeach ?>
        $('#container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Thống kê đổi thưởng'
                },
                xAxis: {
                    categories: array_date
                },
                yAxis: {
                    title: {
                        text: 'Rate'
                    }
                },
                series: [{
                    name: 'Tiền rút',
                    data: sum_money
                }]
            });
        });
        <?php endif; ?>
    </script>

    <script type="text/javascript">
        $(function() {
            $('#deleteModal').on("show.bs.modal", function (e) {
                $("#exchangeId").val($(e.relatedTarget).data('id'));
                $("#type").val($(e.relatedTarget).data('type'));
            });
        });

        $(function() {
            $('#modal-table').on("show.bs.modal", function (e) {

                var id = $(e.relatedTarget).data('id');
                var type = $(e.relatedTarget).data('type');
                $.get('/revenue/exchangeRequest/getMatchLog/' + id, function( data ) {
                    $("#table-scroll").html(data);
                });

                document.getElementById("requestUserId").innerHTML = $(e.relatedTarget).data('id');
            });
        });

        function checkRequired()
        {
            var description =document.getElementById("des").value;
            if(description == '')
            {
                alert('Bạn phải nhập lý do từ chối');
                return false;
            }
            else
            {
                document.getElementById("formSubmit").submit();
            }
        }

    </script>
@endsection