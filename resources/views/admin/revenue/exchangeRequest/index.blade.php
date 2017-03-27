@extends('layouts.master')
@section('title')
    Chi tiết giao dịch đổi thưởng
@endsection
@section('content')
    <div class="page-header">
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/exchangeRequest','role'=>'search'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">SĐT xác thực</label>
                                    <input class="form-control" name="phone" type="text" value="{{request('phone')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Trạng thái</label>
                                    {!! Form::select('status', $statusArr, request('status'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>

                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian đổi thẻ</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timeRequest" id="id-date-range-picker-1" value="{{request('timeRequest')}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Request topup</label>
                                    <input class="form-control" name="requestTopup" type="text" value="{{request('requestTopup')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">ResponseData</label>
                                    <input class="form-control" name="responseData" type="text" value="{{request('responseData')}}"/>
                                </div>


                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
                            {{--</form>--}}
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>User ID</th>
                            <th class="hidden-480">Tên hiển thị</th>
                            <th>Tên đăng nhập</th>
                            <th>SDT xác thực</th>
                            <th class="hidden-480">Asset</th>
                            <th>Total cash</th>
                            <th>Giá trị thẻ</th>
                            <th>Trạng thái</th>
                            <th>Response data</th>
                            <th>Request topup</th>
                            <th>Thời gian tạo</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $rs->requestUserId }}</td>
                            <td>{{ $rs->requestUserName }}</td>
                            <td class="hidden-480">{{ $rs->requestUserName }}</td>
                            <td></td>
                            <td>{{ $rs->assetId }}</td>
                            <td>{{ $rs->totalCash }}</td>
                            <td>{{ $rs->totalParValue }}</td>
                            <td>{{ $rs->status }}</td>
                            <td>{{ $rs->responseData }}</td>
                            <td>{{ $rs->request_topup_id }}</td>
                            <td>{{ $rs->created_at }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->
                {{ $data->appends($_GET)->links() }}
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

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

    @endsection