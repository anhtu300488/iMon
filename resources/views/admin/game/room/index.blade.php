@extends('layouts.master')
@section('title')
    Danh sách phòng game
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
                            {!! Form::open(['method'=>'GET','url'=>'game/room','role'=>'search'])  !!}
                            <div class="row">
                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Game ID</label>
                                    <input class="form-control" name="gameId" type="text" />
                                </div>

                                <div class="col-xs-4 col-sm-4">
                                    <label for="form-field-select-1">Room name</label>
                                    <input class="form-control" name="roomName" type="text" />
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
                                <div class="col-xs-6 col-sm-6">
                                    @permission('administrator')
                                    <a class="btn btn-info btn-sm" href="{{ route('room.create') }}"> Create New</a>
                                    @endpermission
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
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="hidden-480">STT</th>
                            <th class="hidden-480">Game ID</th>
                            <th>Room name</th>
                            <th>Vip room</th>
                            <th>Min cash</th>
                            <th>Min gold</th>
                            <th>Min level</th>
                            <th class="hidden-480">Room capacity</th>
                            <th class="hidden-480">Player size</th>
                            <th>Min bet</th>
                            <th class="hidden-480">Tax</th>
                            <th class="hidden-480">Max roomplay</th>
                            <th class="hidden-480">Permanent room play</th>
                            <th class="hidden-480">Kick limit</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>Start time</th>
                            <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>End time</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td class="hidden-480">{{ ++$i }}</td>
                                <td class="hidden-480">{{ $rs->gameId }}</td>
                                <td>{{ $rs->roomName }}</td>
                                <td>{{ $rs->vipRoom }}</td>
                                <td>{{ $rs->minCash }}</td>
                                <td>{{ $rs->minGold }}</td>
                                <td>{{ $rs->minLevel }}</td>
                                <td class="hidden-480">{{ $rs->roomCapacity }}</td>
                                <td class="hidden-480">{{ $rs->playerSize }}</td>
                                <td>{{ $rs->minBet }}</td>
                                <td class="hidden-480">{{ $rs->tax }}</td>
                                <td class="hidden-480">{{ $rs->maxRoomPlay }}</td>
                                <td class="hidden-480">{{ $rs->permanentRoomPlay }}</td>
                                <td class="hidden-480">{{ $rs->kickLimit }}</td>
                                <td class="hidden-480">{{ $rs->startTime }}</td>
                                <td class="hidden-480">{{ $rs->endTime }}</td>
                                <td>@if($rs->status == 1)  <span class="label label-sm label-success">Success</span> @else <span class="label label-sm label-inverse arrowed-in">Unsucess</span> @endif</td>
                                <td>
                                    @permission('administrator')
                                    <a class="btn btn-xs btn-info" href="{{ route('room.edit',$rs->roomId) }}">
                                        <i class="ace-icon fa fa-pencil bigger-120"></i>
                                    </a>
                                    @endpermission
                                    @permission('administrator')
                                    {!! Form::open(['method' => 'DELETE','route' => ['room.destroy', $rs->roomId],'style'=>'display:inline']) !!}
                                    {{--{!! Form::submit('', ['class' => 'btn btn-xs btn-danger']) !!}--}}
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

@endsection