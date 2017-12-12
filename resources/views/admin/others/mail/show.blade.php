@extends('layouts.master')
@section('title')
    Chi tiết mail
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div style="font-size: 24px; color: black; font-weight: bold;"> {{$data->title}}</div>
                <hr>
                <div>
                    <div style="font-weight: bold; font-size: 20px;">{{$data->senderUserName}} </div>
                    <br />
                    <div style="font-size: 18px;">tới {{$data->recipientUserName}} </div>
                    <br />
                    <div style="font-size: 18px;">{{$data->body}} </div>
                </div>
                <hr>
                <?php $reply = getMailReply($data->messageId); ?>
                @foreach($reply as $k => $v)
                <div>
                    <div style="font-weight: bold; font-size: 20px;">{{$v->senderUserName}} </div>
                    <br />
                    <div style="font-size: 18px;">tới {{$v->recipientUserName}} </div>
                    <br />
                    <div style="font-size: 18px;">{{$v->body}} </div>
                </div>
                <hr>
                @endforeach
                <div id="formReply">
                    {!! Form::open(array('route' => 'mail.store','method'=>'POST', 'class' => 'form-horizontal')) !!}
                    <input type="hidden" name="title" value="{{$data->title}}">
                    <input type="hidden" name="recipientUserId" value="{{$data->senderUserId}}">
                    <input type="hidden" name="recipientUserName" value="{{$data->senderUserName}}">
                    <input type="hidden" name="senderUserId" value="{{$data->recipientUserId}}">
                    <input type="hidden" name="senderUserName" value="{{$data->recipientUserName}}">
                    <input type="hidden" name="parentId" value="{{$data->messageId}}">
                    <div class="form-group">
                        <div class="col-sm-9">
                            {!! Form::textarea('body') !!}
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                            <button class="btn btn-info" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Gửi
                            </button>
                    </div>

                    <div class="hr hr-24"></div>

                    {!! Form::close() !!}
                </div>
                <div id="replyButton">
                    <button class="btn btn-info btn-sm" onclick="replyFunction()">
                        <span class="ace-icon fa fa-reply icon-on-right bigger-110"></span>
                        Trả lời
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="cancelFunction()">
                        <span class="ace-icon fa fa-close icon-on-right bigger-110"></span>
                        Đóng
                    </button>
                </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <script type="text/javascript">
        document.getElementById("formReply").style.display = "none";
        function replyFunction() {
            var x = document.getElementById("formReply");
            x.style.display = "block";
            var y = document.getElementById("replyButton");
            y.style.display = "none";
        }
        function cancelFunction() {
//            location.replace(document.referrer);
            window.history.back();
        }
    </script>
@endsection
