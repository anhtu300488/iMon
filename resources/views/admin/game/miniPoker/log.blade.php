@extends('layouts.master')
@section('title')
    Lịch sử quay MiniPoker
@endsection
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <div id="piechart_pub_type"></div>
            </div>
            <div class="col-sm-6">
                <?php if(isset($sumByFilter[1])){ ?>
                <h5 style="display: inline"><?php echo __('Tổng Ken cược: ', array(), 'messages') ?><?php echo numberFormat($sumByFilter[1]->sum_bet) ?></h5></br>
                <h5 style="display: inline"><?php echo __('Tổng Ken thắng: ', array(), 'messages') ?><?php echo numberFormat($sumByFilter[1]->sum_win) ?></h5></br>
                <?php  }?>
                <?php if(isset($sumByFilter[0])){ ?>
                <h5 style="display: inline"><?php echo __('Tổng Xu cược: ', array(), 'messages') ?><?php echo numberFormat($sumByFilter[0]->sum_bet) ?></h5></br>
                <h5 style="display: inline"><?php echo __('Tổng Xu Thắng: ', array(), 'messages') ?><?php echo numberFormat($sumByFilter[0]->sum_win) ?></h5></br>
                <?php  }?>
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
                            {!! Form::open(['method'=>'GET','url'=>'game/logMiniPoker','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">User ID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Tiền cược</label>

                                    {!! Form::select('type', $arr_type, request('type'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Description</label>
                                    {!! Form::select('card', $arr_card, request('card'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
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
                            <th>STT</th>
                            <th>User ID</th>
                            <th>Tiền cược</th>
                            <th>Win money</th>
                            <th>Quân bài</th>
                            <th>Desciption</th>
                            <th>Loại thẻ</th>
                            <th>Time</th>
                            <th>Chơi Ken</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->userId }}</td>
                                <td>{{ $rs->betMoney }}</td>
                                <td>{{ $rs->winMoney }}</td>
                                <td>{{ $rs->cards }}</td>
                                <td>{{ $rs->desciption }}</td>
                                <td>{{ $rs->cardType }}</td>
                                <td>{{ $rs->insertTime }}</td>
                                <td>{{ $rs->isCash }}</td>
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
    <script type="text/javascript" src="{!! asset('css/jsapi.css') !!}"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var formatter = new google.visualization.NumberFormat({
                pattern: '###,###'
            });

            //Hình 1: Loại nhà phát triển
            var array_type = new Array(['Task', '<?php echo __('Tỷ lệ nhận thưởng')?>']);
            <?php foreach ($list_by_round as $value) {?>
            array_type.push(['<?php echo $arr_card[$value->cardType]?>', <?php echo $value->count_router; ?>]);
                <?php } ?>
            var data_api = google.visualization.arrayToDataTable(array_type);
            formatter.format(data_api, 1);
            var options_api = {
                title: '<?php echo __('Tỷ lệ nhận thưởng')?>',
                is3D: true
            };
            var chart_api = new google.visualization.PieChart(document.getElementById('piechart_pub_type'));
            chart_api.draw(data_api, options_api);

        }
    </script>
@endsection