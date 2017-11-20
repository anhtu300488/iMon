@extends('layouts.master')
@section('title')
    Lịch sử tiền chơi game
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/historyMoney','role'=>'search', 'id' => 'formSearch', 'name' => 'formSearch'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">User ID </label>
                                    <input class="form-control" name="userId" id="userId" type="text" value="{{request('userId')}}" autofocus/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Game</label>
                                    {!! Form::select('game', $gameArr, request('game'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>
                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy h:i:s" name="fromDate" value="{{request('fromDate')}}"/>
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr />
<!--                             <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <button type="submit" class="btn btn-info btn-sm" onclick="checkRequired()">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                            </div> -->
                            {!! Form::close() !!}
                                                        <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" id="search_button" onclick="document.formSearch.submit();" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="{{ route('historyMoney.excel', ['userId' => request('userId'),'fromDate' => request('fromDate'),'userName' => request('userName'), 'game' => request('game')]) }}">
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
                            <th class="hidden-480">User ID</th>
                            <th>Tên đăng nhập</th>
                            <th class="hidden-480">Mon ban đầu</th>
                            <th>Thay đổi Mon</th>
                            <th>Mon hiện tại</th>
                            <th class="hidden-480">Loại giao dịch</th>
                            <th class="hidden-480">Tax percent</th>
                            <th>Tax value</th>
                            <th class="hidden-480">Game</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Inserted time</th>
                            <th class="hidden-480">Mô tả</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                        <tr>
                            <td class="hidden-480">{{ ++$i }}</td>
                            <td class="hidden-480">{{ $rs->userId}}</td>
                            <td>{{ $rs->userName }}</td>
                            <td class="hidden-480">{{ number_format($rs->lastCash) }}</td>
                            <td>{{ number_format($rs->changeCash) }}</td>
                            <td>{{ number_format($rs->currentCash) }}</td>
                            <td class="hidden-480">{{ $transactionArr[$rs->transactionId] }}</td>
                            <td class="hidden-480">{{ $rs->taxPercent }}%</td>
                            <td>{{ $rs->taxValue }}</td>
                            <td class="hidden-480">{{ isset($gameArr[$rs->gameId]) ? $gameArr[$rs->gameId] : $rs->gameId }}</td>
                            <td class="hidden-480">{{ $rs->insertedTime }}</td>
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
              $('.date-picker').daterangepicker(
                  {
                      timePicker: true,
                      format: 'DD/MM/YYYY H:mm:s',
                      startDate: '<?php echo date('d/m/Y 00:00:00')?>',
                      endDate: '<?php echo date('d/m/Y H:mm:s')?>'
                  }
              );

            // $('.date-picker').datepicker({
            //     autoclose: true,
            //     todayHighlight: true
            // })
            // //show datepicker when clicking on the icon
            //     .next().on(ace.click_event, function(){
            //     $(this).prev().focus();
            // });

            // //or change it into a date range picker
            // $('.input-daterange').datepicker({autoclose:true});

        });
    </script>

    @endsection