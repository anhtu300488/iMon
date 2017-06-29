@extends('layouts.master')
@section('title')
    Kiểm tra nạp thẻ lỗi
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
                            {!! Form::open(['method'=>'GET','url'=>'moneyGame/purchaseMoneyError','role'=>'search', 'name' => 'formSearch'])  !!}
                            {{--<form action="{{url('logPayment')}}" role="search" method="get" >--}}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">UserID</label>
                                    <input class="form-control" name="userId" type="text" value="{{request('userId')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Nhà cung cấp</label>
                                    {!! Form::select('provider', $providerArr, request('provider'), ['class' => 'form-control', 'id' => "form-field-select-1"]) !!}
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Mã thẻ</label>
                                    <input class="form-control" name="cardSerial" type="text" value="{{request('cardSerial')}}"/>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label for="id-date-picker-1">Mã pin</label>
                                    <input class="form-control" name="cardPin" type="text" value="{{request('cardPin')}}"/>
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <!-- #section:plugins/date-time.datepicker -->
                                    <label  for="id-date-picker-1">Ngày nạp</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="timeRequest" id="id-date-range-picker-1" value="{{request('timeRequest')}}" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <hr />
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <button type="submit" id="search_button" class="btn btn-info btn-sm">
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
                            <th>Tên đăng nhập</th>
                            <th class="hidden-480">Nhà cung cấp</th>
                            <th>Mã thẻ</th>
                            <th>Mã pin</th>
                            <th>Mệnh giá</th>
                            <th>Trạng thái</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Ngày nạp</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr @if($rs->status === 5) style="background-color:#3a87ad; color: white" @endif >
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $rs->userId }}</td>
                                <td class="hidden-480">{{ $rs->userName }}</td>
                                <td>{{ $rs->provider }}</td>
                                <td class="hidden-480">{{ $rs->cardSerial }}</td>
                                <td>{{ $rs->cardPin }}</td>
                                <td>{{ getParValue($rs->cardSerial,$rs->cardPin) }}</td>
                                <td>{{ checkPurchaseMoney($rs->cardSerial,$rs->cardPin) == 0 ? 'Thẻ nạp không bị lỗi' : 'Thẻ nạp bị lỗi'}}</td>
                                <td>{{ $rs->requestedTime }}</td>

                                <td>
                                    @permission('administrator')
                                    {{--{!! Form::open(['method' => 'PATCH','route' => ['errorPurchaseMoney.update', $rs->purchaseErrorId],'style'=>'display:inline']) !!}--}}
                                        <button class="btn btn-xs btn-info" type="button" data-id = "{{$rs->purchaseErrorId}}" data-userid="{{$rs->userId}}" data-provider="{{$rs->provider}}" data-serial="{{$rs->cardSerial}}" data-pin="{{$rs->cardPin}}" data-toggle="modal" data-target="#purchaseMoneyModal" title="Bù tiền">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </button>
                                    {{--{!! Form::close() !!}--}}
                                    @endpermission
                                    @permission('administrator')
                                    {!! Form::open(['method' => 'DELETE','route' => ['errorPurchaseMoney.destroy', $rs->purchaseErrorId],'style'=>'display:inline']) !!}
                                    <button class="btn btn-xs btn-danger" type="submit">
                                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                    </button>
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

    <div class="modal fade" id="purchaseMoneyModal" tabindex="-1" role="dialog" aria-labelledby="purchaseMoneyModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteModalLabel">Bù tiền nạp thẻ lỗi</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'POST','url' => 'moneyGame/errorPurchaseMoney/purchaseMoney','style'=>'display:inline', 'id' => 'formSubmit']) !!}
                    {!! csrf_field() !!}
                    <input type="hidden" name="purchaseErrorId" class="id" id="purchaseErrorId">
                    <input type="hidden" name="cardSerial" class="id" id="serial">
                    <input type="hidden" name="cardPin" class="id" id="pin">
                    <input type="hidden" name="provider" class="id" id="provider">
                    <input type="hidden" name="userId" class="id" id="userId">
                    <div class="form-group">
                        <label for="cardValue" class="control-label">Nhập mệnh giá</label>
                        <input class="form-control" type="text" id="cardValue" name="cardValue">
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
        $(function() {
            $('#purchaseMoneyModal').on("show.bs.modal", function (e) {
                $("#purchaseErrorId").val($(e.relatedTarget).data('id'));
                $("#userId").val($(e.relatedTarget).data('userid'));
                $("#provider").val($(e.relatedTarget).data('provider'));
                $("#serial").val($(e.relatedTarget).data('serial'));
                $("#pin").val($(e.relatedTarget).data('pin'));
            });
        });

        function checkRequired()
        {
            var cardValue =document.getElementById("cardValue").value;
            if(cardValue == '')
            {
                alert('Bạn phải nhập mệnh giá thẻ');
                return false;
            }
            else
            {
                document.getElementById("formSubmit").submit();
            }
        }

    </script>
@endsection