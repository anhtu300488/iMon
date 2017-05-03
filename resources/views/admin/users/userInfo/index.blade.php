@extends('layouts.master')
@section('title')
    Thông tin người chơi
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
                            {!! Form::open(['method'=>'GET','url'=>'users/userInfo','role'=>'search'])  !!}
                            <div class="row">

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">UserID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>


                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>


                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Tên hiển thị</label>
                                    <input class="form-control" name="displayName" type="text" value="{{request('displayName')}}"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Từ ngày</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" name="fromDate" value="{{request('fromDate')}}"/>
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

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">SDT xác thực</label>
                                    <input class="form-control" name="phone" type="text" value="{{request('phone')}}"/>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Thông tin thiết bị</label>
                                    <input class="form-control" name="device" type="text" value="{{request('device')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Top</label>

                                    <select class="form-control" id="form-field-select-1" name="top">
                                        <option value="">Mới nhất</option>
                                        <option value="1" <?php if(request('top') == 1) echo "selected='selected'"; ?> >Level</option>
                                        <option value="2" <?php if(request('top') == 2) echo "selected='selected'"; ?> >Đại gia Ken</option>
                                        <option value="3" <?php if(request('top') == 3) echo "selected='selected'"; ?> >Đại gia Xu</option>
                                        <option value="4" <?php if(request('top') == 4) echo "selected='selected'"; ?> >Số ván chơi</option>
                                        <option value="5" <?php if(request('top') == 5) echo "selected='selected'"; ?> >Số ván thắng</option>
                                        <option value="6" <?php if(request('top') == 6) echo "selected='selected'"; ?> >Top nạp thẻ</option>
                                    </select>
                                </div>

                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div>
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
                            <th>UserID</th>
                            <th class="hidden-480">Tên đăng nhập</th>
                            <th>Tên hiển thị</th>
                            <th class="hidden-480">Cp</th>
                            <th class="hidden-480">Chỉ số tín nhiệm</th>
                            <th class="hidden-480">SDT xác thực</th>
                            <th class="hidden-480">Device</th>
                            <th class="hidden-480">Tổng số trận</th>
                            <th>Số trận thắng</th>
                            <th>Số trận thua</th>
                            <th>Ken</th>
                            <th>Xu</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td class="hidden-480">{{ $rs->userName }}</td>
                                <td>{{ $rs->displayName }}</td>
                                <td class="hidden-480">{{ $rs->cp }}</td>
                                <td class="hidden-480">{{ $rs->trustedIndex }}</td>
                                <td class="hidden-480">{{ $rs->verifiedPhone }}</td>
                                <td class="hidden-480">{{ $rs->device }}</td>
                                <td class="hidden-480">{{ $rs->totalMatch }}</td>
                                <td>{{ $rs->totalWin }}</td>
                                <td>{{ $rs->totalLost }}</td>
                                <td>{{ $rs->cash }}</td>
                                <td>{{ $rs->gold }}</td>
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