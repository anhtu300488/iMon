@extends('layouts.master')
@section('title')
    Thống kê tiền phế
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
                            {!! Form::open(['method'=>'GET','url'=>'revenue/wasteMoney','role'=>'search', 'name' => 'formSearch'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Thời gian</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timeRequest" id="id-date-range-picker-1" value="{{request('timeRequest')}}" />
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
                            {!! Form::close() !!}
                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" onclick="document.formSearch.submit();" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Tìm kiếm
                                    </button>
                                </div>
                                <div class="col-xs-6 col-sm-6">
                                    <a href="{{ route('wasteMoney.excel', ['timeRequest' => request('timeRequest'), 'game' => request('game')]) }}">
                                        <button class="btn btn-info btn-sm">
                                            Download Excel xlsx
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
                            <th class="hidden-480">Ngày</th>
                            <th>Tổng phế</th>
                            <?php foreach($list_games  as $valgame): ?>
                            <th><?php echo $valgame['name'] ?></th>
                            <?php endforeach ?>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ $key }}</td>
                                <td>
                                @foreach($list_games  as $valgame)
                                    <?php
                                    $value = isset($rs[$valgame['gameId']]) ? $rs[$valgame['gameId']] : 0;
                                    $arrRevenue[] = $value;
                                    ?>
                                @endforeach
                                <?php
                                    $arrRevenueTotal[] = array_sum($arrRevenue);
                                    // Hiển thị dữ liệu
                                    if (array_sum($arrRevenue) == 0) {
                                        echo '-';
                                    } else {
                                        echo number_format(array_sum($arrRevenue));
                                    }

                                ?>
                                </td>
                                <?php $arrRevenue = array();?>
                                <?php foreach($list_games  as $valgame): ?>
                                <th><?php echo isset($rs[$valgame['gameId']]) ? number_format($rs[$valgame['gameId']]) : '-'; ?></th>
                                <?php endforeach; ?>
                            </tr>
                        @endforeach

                        <?php if (count($data) == 0){ ?>
                        <tr>
                            <td colspan="8"><?php echo __('Không có dữ liệu nào!') ?></td>
                        </tr>
                        <?php } else { ?>
                        <tr style="font-weight: bold">
                            <td colspan="1" style="text-align: center"><?php echo __('Tổng cộng') ?></td>
                            <td style="text-align: center">
                                <?php echo number_format(array_sum($arrRevenueTotal)); ?>
                            </td>
                        </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div><!-- /.span -->
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