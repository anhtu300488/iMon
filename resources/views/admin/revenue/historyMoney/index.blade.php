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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/historyMoney','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">User ID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Tên đăng nhập</label>
                                    <input class="form-control" name="userName" type="text" value="{{request('userName')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Loại</label>
                                    {!! Form::select('type', $typeArr, request('type'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

                                </div>

                            </div>
                            <br/>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian nạp thẻ</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="date_charge" id="id-date-range-picker-1" value="{{request('date_charge')}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label  for="form-field-select-1">Game</label>
                                    {!! Form::select('game', $gameArr, request('game'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}

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
                            <th class="hidden-480">Tên hiển thị</th>
                            <th class="hidden-480">User ID</th>
                            <th>Tên đăng nhập</th>
                            <th class="hidden-480">Ken ban đầu</th>
                            <th>Thay đổi Ken</th>
                            <th>Ken hiện tại</th>
                            <th class="hidden-480">Xu ban đầu</th>
                            <th>Thay đổi Xu</th>
                            <th>Xu hiện tại</th>
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
                            <td class="hidden-480">{{ $rs->userName }}</td>
                            <td class="hidden-480">{{ $rs->userId}}</td>
                            <td>{{ $rs->userName }}</td>
                            <td class="hidden-480">{{ $rs->lastCash }}</td>
                            <td>{{ $rs->changeCash }}</td>
                            <td>{{ $rs->currentCash }}</td>
                            <td class="hidden-480">{{ $rs->lastGold }}</td>
                            <td>{{ $rs->changeGold }}</td>
                            <td>{{ $rs->currentGold }}</td>
                            <td class="hidden-480">{{ $rs->transactionId }}</td>
                            <td class="hidden-480">{{ $rs->taxPercent }}</td>
                            <td>{{ $rs->taxValue }}</td>
                            <td class="hidden-480">{{ $rs->gameId }}</td>
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

            //or change it into a date range picker
            $('.date_charge').datepicker({autoclose:true});


            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=date_charge]').daterangepicker({
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