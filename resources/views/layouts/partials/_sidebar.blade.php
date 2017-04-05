<!-- #section:basics/sidebar -->
<div id="sidebar" class="sidebar                  responsive">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="ace-icon fa fa-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="ace-icon fa fa-pencil"></i>
            </button>

            <!-- #section:basics/sidebar.layout.shortcuts -->
            <button class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>

            <!-- /section:basics/sidebar.layout.shortcuts -->
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li {{ setActive('home') }}>
            <a href="{{url('home')}}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
        </li>

        <li {{ setOpen('revenue') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text"> Doanh Thu </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li {{ setActive('revenue/revenueDay') }}>
                    <a href="{{route('revenue.revenueDay')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Doanh thu theo ngày
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/rechargeTransaction') }}>
                    <a href="{{route('revenue.rechargeTransaction')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Chi tiết giao dịch nạp tiền
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li class="">--}}
                    {{--<a href="form-wizard.html">--}}
                        {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                        {{--Tiền phế trong game--}}
                    {{--</a>--}}

                    {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('revenue/historyMoney') }}>
                    <a href="{{route('revenue.historyMoney')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử tiền chơi game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/logPayment') }}>
                    <a href="{{route('revenue.logPayment')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử nạp thẻ
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/smsRevenue') }}>
                    <a href="{{route('revenue.smsRevenue')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Doanh thu SMS
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/moRevenue') }}>
                    <a href="{{route('revenue.moRevenue')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Chi tiết MO SIM
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/detailSmsHistory') }}>
                    <a href="{{route('revenue.detailSmsHistory')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Chi tiết MO SMS
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/exchangeRequest') }}>
                    <a href="{{route('revenue.exchangeRequest')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê đổi thưởng
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/ccu') }}>
                    <a href="{{route('revenue.ccu')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý CCU
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/userOnline') }}>
                    <a href="{{route('revenue.userOnline')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý user online
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li {{ setOpen('game') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-list-alt"></i>
                <span class="menu-text"> Game </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li {{ setActive('game/emergencyNotification') }}>
                    <a href="{{route('emergencyNotification.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý thông báo khẩn cấp trong game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/manageGame') }}>
                    <a href="{{route('game.manageGame')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/matchLog') }}>
                    <a href="{{route('game.matchLog')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê ván đánh
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/room') }}>
                    <a href="{{route('room.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý phòng game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/logLuckyWheel') }}>
                    <a href="{{route('game.logLuckyWheel')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử vòng quay may mắn
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/itemLuckyWheel') }}>
                    <a href="{{route('game.itemLuckyWheel')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê tỉ lệ quay vòng quay may mắn
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/chanceLuckyWheel') }}>
                    <a href="{{route('game.chanceLuckyWheel')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê số lượt quay vòng quay may mắn
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li {{ setOpen('moneyGame') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-calendar"></i>
                <span class="menu-text"> Tiền trong game </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>
            <ul class="submenu">
                <li {{ setActive('moneyGame/cardProvider') }}>
                    <a href="{{route('moneyGame.cardProvider')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý nhà cung cấp thẻ
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('moneyGame/giftCode') }}>
                    <a href="{{route('giftCode.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý mã quà tặng
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('moneyGame/eventGift') }}>
                    <a href="{{route('eventGift.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý quà sự kiện
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('moneyGame/purchaseMoney') }}>
                    <a href="{{route('purchaseMoney.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                       Bù tiền nạp thẻ lỗi
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('moneyGame/addMoney') }}>
                    <a href="{{route('addMoney.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cộng tiền cho người dùng
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li {{ setOpen('users') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-tag"></i>
                <span class="menu-text"> Người chơi game </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li {{ setActive('users/userReg') }}>
                    <a href="{{route('users.userReg')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý user đăng ký
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/userInfo') }}>
                    <a href="{{route('users.userInfo')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý thông tin người chơi
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/otp') }}>
                    <a href="{{route('users.otp')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý OTP
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/autoOtp') }}>
                    <a href="{{route('users.autoOtp')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý OTP tự kích hoạt
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/logUserLogin') }}>
                    <a href="{{route('users.logUserLogin')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý log user đăng nhập
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li {{ setOpen('others') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-file-o"></i>
                <span class="menu-text"> Các phân hệ khác </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li {{ setActive('others/linkDownload') }}>
                    <a href="{{route('linkDownload.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý link tải game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/logWeb') }}>
                    <a href="{{route('logWeb.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý log truy cập web
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li {{ setActive('others/testCase') }}>--}}
                    {{--<a href="{{route('testCase.index')}}">--}}
                        {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                        {{--Quản lý testcase--}}
                    {{--</a>--}}

                    {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('others/clientType') }}>
                    <a href="{{route('clientType.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý hệ điều hành
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/partner') }}>
                    <a href="{{route('partner.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý đối tác
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/provider') }}>
                    <a href="{{route('provider.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Danh sách nhà mạng
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/notify') }}>
                    <a href="{{route('notify.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý notify game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/messageUser') }}>
                    <a href="{{route('messageUser.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý tin nhắn đến user
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/webContent') }}>
                    <a href="{{route('webContent.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý nội dung web
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('others/notification') }}>
                    <a href="{{route('notification.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý notifications bắn vào game
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <!-- Sidebar Ruby -->
        <li {{ setOpen('basic') }} >
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-desktop"></i>
                <span class="menu-text">
                            Chức năng cơ bản
                        </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li {{ setActive('basic/purchaseMoneyLog') }} >
                    <a href="{{url('basic/purchaseMoneyLog')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Danh sách nạp thẻ
                    </a>
                </li>

                <li {{ setActive('basic/topUser') }}>
                    <a href="{{route('basic.topUser')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        TOP người dùng nạp tiền
                    </a>

                </li>

                <li {{ setActive('basic/userReg') }}>
                    <a href="{{route('basic.userReg')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Người dùng đăng ký
                    </a>

                </li>

                <li {{ setActive('basic/exchangeAssetRequest') }}>
                    <a href="{{route('basic.exchangeAssetRequest')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Danh sách đổi thẻ
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('basic/history') }}>
                    <a href="{{route('basic.history')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('basic/kenHistory') }}>
                    <a href="{{route('basic.kenHistory')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử Ken
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('basic/xuHistory') }}>
                    <a href="{{route('basic.xuHistory')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử xu
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li class="">--}}
                {{--<a href="jquery-ui.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Lịch sử vật phẩm--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                {{--<li class="">--}}
                {{--<a href="nestable-list.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Lịch sử thanh toán--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

            </ul>
        </li>

        <li {{ setOpen('tool') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text"> Tool Server </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                {{--<li {{ setActive('tool/topGame') }}>--}}
                {{--<a href="{{route('tool.topGame')}}">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Top Game--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('tool/roles') }}>
                    <a href="{{route('tool.roles')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Danh sách role
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li {{ setActive('tool/userInfo') }}>--}}
                {{--<a href="{{route('tool.userInfo')}}">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Thông tin người chơi--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('tool/createAdmin/create') }}>
                    <a href="{{route('tool.createAdmin.create')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tạo User
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li class="">--}}
                {{--<a href="form-wizard.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Lịch sử ván chơi--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                {{--<li class="">--}}
                {{--<a href="wysiwyg.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Cập nhật mật khẩu--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('tool/addMoney') }}>
                    <a href="{{url('tool/addMoney')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cộng tiền cho người chơi
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li {{ setActive('tool/serverMessage/create') }}>--}}
                {{--<a href="{{route('tool.serverMessage.create')}}">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Thông báo toàn server--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('tool/sendEmail/create') }}>
                    <a href="{{route('tool.sendEmail.create')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Gửi email cho người dùng
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('tool/lockUser') }}>
                    <a href="{{route('tool.lockUser')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Khóa tài khoản
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('tool/unlockUser') }}>
                    <a href="{{route('tool.unlockUser')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Mở khóa tài khoản
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li class="">--}}
                {{--<a href="dropzone.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Kiểm tra trạng thái user--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('tool/emailUpdate') }}>
                    <a href="{{route('tool.emailUpdate')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cập nhật địa chỉ email
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('tool/phoneUpdate') }}>
                    <a href="{{route('tool.phoneUpdate')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cập nhật số điện thoại
                    </a>

                    <b class="arrow"></b>
                </li>

                {{--<li class="">--}}
                {{--<a href="dropzone.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Mở khóa thiết bị--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                {{--<li class="">--}}
                {{--<a href="dropzone.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Khóa thiết bị--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('tool/giftCode') }}>
                    <a href="{{route('tool.giftCode')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thông tin GiftCode
                    </a>

                    <b class="arrow"></b>
                </li>


            </ul>
        </li>

        {{--<li {{ setOpen('report') }}>--}}
        {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="menu-icon fa fa-calendar"></i>--}}
        {{--<span class="menu-text"> Thống kê </span>--}}

        {{--<b class="arrow fa fa-angle-down"></b>--}}
        {{--</a>--}}

        {{--<b class="arrow"></b>--}}

        {{--<ul class="submenu">--}}
        {{--<li class="">--}}
        {{--<a href="tables.html">--}}
        {{--<i class="menu-icon fa fa-caret-right"></i>--}}
        {{--Daily active user--}}
        {{--</a>--}}

        {{--<b class="arrow"></b>--}}
        {{--</li>--}}

        {{--</ul>--}}
        {{--</li>--}}

        <li {{ setOpen('system') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Tương tác hệ thống </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                {{--<li class="">--}}
                {{--<a href="profile.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Bảo trì server--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                {{--<li class="">--}}
                {{--<a href="inbox.html">--}}
                {{--<i class="menu-icon fa fa-caret-right"></i>--}}
                {{--Cấu hình event đua top--}}
                {{--</a>--}}

                {{--<b class="arrow"></b>--}}
                {{--</li>--}}

                <li {{ setActive('system/ipLock') }}>
                    <a href="{{route('system.ipLock')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Khóa IP
                    </a>

                    <b class="arrow"></b>
                </li>

            </ul>
        </li>
    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>
<!-- /section:basics/sidebar -->
