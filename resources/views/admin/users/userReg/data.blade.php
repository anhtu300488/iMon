{!! Form::open(['method'=>'POST','url'=>'users/userReg/unlockUser','role'=>'search', 'name' => 'formLockUser'])  !!}
{{ csrf_field() }}
<button class="btn btn-warning" type="button" name="lock" value="lock" data-type="2" data-toggle="modal" data-target="#lockUserModal" >Tạm khóa</button> <button class="btn btn-danger" type="button" name="delete" value="delete" data-type="1" data-toggle="modal" data-target="#lockUserModal">Khóa vĩnh viễn</button> <button class="btn btn-success" type="submit" name="unlock" value="unlock" onclick="confirm('Bạn có chắc muốn mở khóa cho user?')">Mở khóa</button> <button class="btn btn-grey" type="button" name="resetPw" value="resetPw" data-type="2" data-toggle="modal" data-target="#resetPwModal" >Reset mật khẩu</button>
<hr />
<table id="simple-table" class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th class="hidden-480">STT</th>
        <th><input type="checkbox" onclick="toggle(this);" /></th>
        <th>UserID</th>
        <th>Tên đăng nhập</th>
        <th>Tên hiển thị</th>
        <th class="hidden-480">IP</th>
        <th>Thiết bị</th>
        <th>Device ID</th>
        <th class="hidden-480">Đối tác</th>
        <th>Nền tảng</th>
        <th>Note</th>
        <th class="hidden-480"><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Ngày đăng ký</th>
        <th>Trạng thái</th>
    </tr>
    </thead>

    <tbody>
    @foreach($data as $key => $rs)
        <tr>
            <td class="hidden-480">STT</td>
            <td><input type="checkbox" name="userIds[]" class="checkboxes" value="{{ $rs->userId }}" /></td>
            <td>{{ $rs->userId }}</td>
            <td>{{ $rs->userName }}</td>
            <td>{{ $rs->displayName }}</td>
            <td class="hidden-480">{{ $rs->ip }}</td>
            <td>{{ $rs->device }}</td>
            <td>{{ $rs->deviceIdentify }}</td>
            <td class="hidden-480">{{ $rs->cp }}</td>
            <td>{{ $clientType[$rs->clientId] }}</td>
            <td>{{ $rs->note }}</td>
            <td class="hidden-480">{{ $rs->registedTime }}</td>
            <td>@if($rs->status == 1)  <span class="label label-sm label-success">Active</span> @elseif($rs->status == 3) <span class="label label-sm label-inverse arrowed-in">Lock</span> @else <span class="label label-sm label-inverse arrowed-in">Deactive</span> @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! Form::close() !!}