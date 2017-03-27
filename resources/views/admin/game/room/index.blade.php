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
                                    @permission('administrator')
                                    <a class="btn btn-info btn-sm" href="{{ route('room.create') }}"> Create New Room</a>
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
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <table id="simple-table" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Game ID</th>
                            <th>Room name</th>
                            <th>Vip room</th>
                            <th>Min cash</th>
                            <th>Min gold</th>
                            <th>Min level</th>
                            <th>Room capacity</th>
                            <th>Player size</th>
                            <th>Min bet</th>
                            <th>Tax</th>
                            <th>Max roomplay</th>
                            <th>Permanent room play</th>
                            <th>Kick limit</th>
                            <th>Start time</th>
                            <th>End time</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $key => $rs)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rs->gameId }}</td>
                                <td>{{ $rs->roomName }}</td>
                                <td>{{ $rs->vipRoom }}</td>
                                <td>{{ $rs->minCash }}</td>
                                <td>{{ $rs->minGold }}</td>
                                <td>{{ $rs->minLevel }}</td>
                                <td>{{ $rs->roomCapacity }}</td>
                                <td>{{ $rs->playerSize }}</td>
                                <td>{{ $rs->minBet }}</td>
                                <td>{{ $rs->tax }}</td>
                                <td>{{ $rs->maxRoomPlay }}</td>
                                <td>{{ $rs->permanentRoomPlay }}</td>
                                <td>{{ $rs->kickLimit }}</td>
                                <td>{{ $rs->startTime }}</td>
                                <td>{{ $rs->endTime }}</td>
                                <td>{{ $rs->status }}</td>
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
                {{ $data->appends($_GET)->links() }}
            </div><!-- /.row -->
        </div><!-- /.col -->
    </div><!-- /.row -->

@endsection