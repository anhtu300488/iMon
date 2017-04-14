@extends('layouts.master')
@section('title')
    Danh sách nạp thẻ
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
                                {!! Form::open(['method'=>'GET','url'=>'basic/purchaseMoneyLog','role'=>'search'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                                <div class="row">
                                    <div class="col-xs-4 col-sm-4">
                                        <!-- #section:plugins/date-time.datepicker -->
                                        <label for="id-date-picker-1">Người dùng</label>
                                        <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                    </div>

                                    <div class="col-xs-4 col-sm-4">
                                        <!-- #section:plugins/date-time.datepicker -->
                                        <label for="id-date-picker-1">Từ ngày</label>
                                        <div class="input-group">
                                            <input class="form-control date-picker col-sm-9" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="fromDate" value="{{request('fromDate')}}"/>
                                            <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                        </div>
                                    </div>

                                    <div class="col-xs-4 col-sm-4">
                                        <!-- #section:plugins/date-time.datepicker -->
                                        <label for="id-date-picker-1">Đến ngày</label>
                                        <div class="input-group">
                                            <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="toDate" value="{{request('toDate')}}"/>
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <br/>

                                <div class="row">
                                    <div class="col-xs-4 col-sm-4">
                                        <label for="form-field-select-1">Pay Type</label>
                                        {!! Form::select('payType', $payTypeArr, request('payType'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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
                            <th class="hidden-480">STT</th>
                            <th class="hidden-480">Người dùng</th>
                            <th>Tên nhân vật</th>
                            <th class="hidden-480">Mã thẻ</th>
                            <th class="hidden-480">Serial thẻ</th>
                            <th class="hidden-480">Loại thẻ</th>
                            <th>Mệnh giá</th>
                            <th class="hidden-480">Pay type</th>
                            <th>Kênh</th>
                            <th>Trạng thái</th>
                            <th class="hidden-480">Nền tảng</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Ngày nạp</th>
                            <th class="hidden-480">Mô tả</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $rs->userId }}</td>
                                <td>{{ $rs->userName }}</td>
                                <td class="hidden-480"></td>
                                <td class="hidden-480"></td>
                                <td class="hidden-480">{{ $payTypeArr[$rs->type] }}</td>
                                <td>{{ number_format($rs->currentCash) }}</td>
                                <td class="hidden-480">{{ $payTypeArr[$rs->type] }}</td>
                                <td>{{ $rs->type }}</td>
                                <td>@if($rs->status == 1)  <span class="label label-sm label-success">Active</span> @else <span class="label label-sm label-inverse arrowed-in">Deactive</span> @endif</td>
                                <td class="hidden-480">{{ $rs->type }}</td>
                                <td class="hidden-480">{{ $rs->purchasedTime }}</td>
                                <td class="hidden-480">{{ $rs->description }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.span -->
                @include('layouts.partials._pagination')
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <script>
        jQuery(function($) {

            //datepicker plugin
            //link
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            })
            //show datepicker when clicking on the icon
                .next().on(ace.click_event, function(){
                $(this).prev().focus();
            });

            //or change it into a date range picker
            $('.input-daterange').datepicker({autoclose:true});

        });
    </script>

@endsection