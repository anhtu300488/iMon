@extends('layouts.master')
@section('title')
    Lịch sử nạp thẻ
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/logPayment','role'=>'search', 'name' => 'formSearch'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="id-date-picker-1">UserID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="fromDate" value="{{request('fromDate')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="id-date-picker-1">Tên hiển thị</label>
                                    <input class="form-control" name="displayName" type="text" value="{{request('displayName')}}"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="id-date-picker-1">Seria</label>
                                    <input class="form-control" name="seria" type="text" value="{{request('seria')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="id-date-picker-1">Mã thẻ cào</label>
                                    <input class="form-control" name="pinCard" type="text" value="{{request('pinCard')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="id-date-picker-1">Mệnh giá thẻ</label>
                                    <input class="form-control" name="money" type="text" value="{{request('money')}}"/>
                                </div>

                            </div>
                            <div class="row">
                                @permission('administrator')
                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Đối tác</label>
                                    {!! Form::select('partner', $partner, request('partner'), ['class' => 'form-control', 'id' => "partner"]) !!}

                                </div>
                                @endpermission
                            </div>
                            <hr />
                                                        {!! Form::close() !!}

                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" id="search_button" onclick="document.formSearch.submit();" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="{{ route('logPayment.excel', ['userId' => request('userId'),'fromDate' => request('fromDate'),'userName' => request('userName'),'displayName' => request('displayName'), 'timeRequest' => request('timeRequest'), 'phone' => request('phone'), 'status' => request('status')]) }}">
                                        <button class="btn btn-info btn-sm">
                                            Download Excel
                                        </button>
                                    </a>
                                </div>
                            </div>
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
                            <th>User ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Tên hiển thị</th>
                            <th class="hidden-480">Seria</th>
                            <th class="hidden-480">Mã thẻ</th>
                            <th>Mệnh giá</th>
                            <th>Message</th>
                            <th>Nhà cung cấp</th>
                            <th>Kênh gạch</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian tạo</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Thời gian cập nhật</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $arrType = array("0" => "", "1" => "paygate-Truc", "3" => "paydirect-Đô", "2" => "Santhe", "4" => "vip-paydirect");?>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->userid }}</td>
                                <th>{{ $rs->userName }}</th>
                                <th>{{ $rs->displayName }}</th>
                                <td class="hidden-480">{{ $rs->seria }}</td>
                                <td class="hidden-480">{{ $rs->pin_card }}</td>
                                <td>{{ number_format($rs->money) }}</td>
                                <td>{{ $rs->message }}</td>
                                <td>{{ $rs->providerId }}</td>
                                <td>{{ isset($arrType[$rs->type])? $arrType[$rs->type]: "" }}</td>
                                <td class="hidden-480">{{ $rs->created_at }}</td>
                                <td class="hidden-480">{{ $rs->updated_at }}</td>
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
              $('.date-picker').daterangepicker(
                  {
                      timePicker: true,
                      format: 'DD/MM/YYYY H:mm:s',
                      startDate: '<?php echo date('d/m/Y 00:00:00')?>',
                      endDate: '<?php echo date('d/m/Y H:mm:s')?>'
                  }
              );

        });
    </script>
@endsection