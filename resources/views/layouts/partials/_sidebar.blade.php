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
                @permission(['administrator','admin', 'customer_care'])

        <li {{ setActive('home') }}>
            <a href="{{url('home')}}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>

            <b class="arrow"></b>
        </li>
                @endpermission

        <li {{ setOpen('revenue') }}>
                @permission(['administrator','admin', 'customer_care'])

            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-desktop"></i>
                <span class="menu-text"> Doanh Thu </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>
                @endpermission
            <b class="arrow"></b>

            <ul class="submenu">
<<<<<<< HEAD
                @permission(['administrator','admin', 'customer_care'])
=======
                @permission(['administrator','admin', 'customer_care', 'cp'])
>>>>>>> 9bd54777236761b6e559ae1bd8b4dcd8b3a85275
                <li {{ setActive('revenue/revenueDay') }}>
                    <a href="{{route('revenue.revenueDay')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Doanh thu theo ngày
                    </a>

                    <b class="arrow"></b>
                </li>
<<<<<<< HEAD
=======
                @endpermission
                @permission(['administrator','admin'])
>>>>>>> 9bd54777236761b6e559ae1bd8b4dcd8b3a85275
                <li {{ setActive('revenue/revenueUserCharge') }}>
                    <a href="{{route('revenue.revenueUserCharge')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê KH nạp tiền
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

                <li {{ setActive('revenue/wasteMoney') }}>
                    <a href="{{route('revenue.wasteMoney')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tiền phế trong game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/historyMoney') }}>
                    <a href="{{route('revenue.historyMoney')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử tiền chơi game
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
                @permission(['administrator','admin', 'cp'])
                <li {{ setActive('revenue/logPayment') }}>
                    <a href="{{route('revenue.logPayment')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử nạp thẻ
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
                @permission(['administrator','admin', 'customer_care'])
                <li {{ setActive('revenue/smsRevenue') }}>
                    <a href="{{route('revenue.smsRevenue')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Doanh thu SMS
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
                @endpermission
                @permission(['administrator','admin', 'cp'])
                <li {{ setActive('revenue/exchangeRequest') }}>
                    <a href="{{route('revenue.exchangeRequest')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê đổi thưởng
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/vip') }}>
                    <a href="{{route('revenue.vip')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Chức năng Vip
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
                @permission(['administrator','admin', 'customer_care'])
                <li {{ setActive('revenue/cashOut') }}>
                    <a href="{{route('revenue.cashOut')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê số lượng thẻ đổi
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/topCashOut') }}>
                    <a href="{{route('revenue.topCashOut')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Top user đổi thưởng
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('revenue/topCharging') }}>
                    <a href="{{route('revenue.topCharging')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Top user nạp tiền
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('revenue/payCashOut') }}>
                    <a href="{{route('revenue.payCashOut')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Số đổi và nạp của user
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
                @permission(['administrator','admin', 'customer_care', 'cp'])
                <li {{ setActive('revenue/ccu') }}>
                    <a href="{{route('revenue.ccu')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý CCU
                    </a>

                    <b class="arrow"></b>
                </li>

                @endpermission
                @permission(['administrator','admin', 'customer_care'])
                <li {{ setActive('revenue/userOnline') }}>
                    <a href="{{route('revenue.userOnline')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý user online
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/revenueUserActive') }}>
                    <a href="{{route('revenue.revenueUserActive')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tiền trung bình của user active
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('revenue/revenueUserPurchase') }}>
                    <a href="{{route('revenue.revenueUserPurchase')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tiền trung bình của user nạp tiền
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
            </ul>
        </li>

        @permission(['administrator','admin', 'customer_care'])
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
                    <a href="{{route('manageGame.index')}}">
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

                <li {{ setActive('game/miniPoker') }}>
                    <a href="{{route('game.miniPoker')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Lịch sử quay MiniPoker
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/rateMiniPoker') }}>
                    <a href="{{route('game.rateMiniPoker')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê tỉ lệ quay MiniPoker
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('game/xocDia') }}>
                    <a href="{{route('game.xocDia')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game xóc đĩa
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('game/tlmn') }}>
                    <a href="{{route('game.tlmn')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game TLMN
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('game/maubinh') }}>
                    <a href="{{route('game.maubinh')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game Mậu Binh
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('game/phom') }}>
                    <a href="{{route('game.phom')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game Phỏm
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('game/bacay') }}>
                    <a href="{{route('game.bacay')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game Ba Cây
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('game/lieng') }}>
                    <a href="{{route('game.lieng')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game Liêng
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('game/xito') }}>
                    <a href="{{route('game.xito')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê game Xì Tố
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        @endpermission
        @permission(['administrator', 'admin'])
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
                @permission(['administrator', 'admin'])
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
                @endpermission
                <li {{ setActive('moneyGame/income') }}>
                    <a href="{{route('income.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tiền vào game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('moneyGame/circulation') }}>
                    <a href="{{route('circulation.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tiền luân chuyển trong game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('moneyGame/errorPurchaseMoney') }}>
                    <a href="{{route('errorPurchaseMoney.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Kiểm tra nạp thẻ lỗi
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        @endpermission
        @permission(['administrator','admin', 'cp'])
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
                @permission(['administrator','admin', 'customer_care'])
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

                <li {{ setActive('users/userRateActive') }}>
                    <a href="{{route('users.userRateActive')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Thống kê tỷ lệ users active
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/topMoney') }}>
                    <a href="{{route('users.topMoney')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Top Mon
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/topGame') }}>
                    <a href="{{route('users.topGame')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Top User chơi Game
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('users/userLock') }}>
                    <a href="{{route('users.userLock')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Danh sách user bị khóa
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
            </ul>
        </li>
        @endpermission
        @permission(['administrator', 'admin'])
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

                <li {{ setActive('others/clientType') }}>
                    <a href="{{route('clientType.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý hệ điều hành
                    </a>

                    <b class="arrow"></b>
                </li>
                @permission(['administrator'])
                <li {{ setActive('others/partner') }}>
                    <a href="{{route('partner.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý đối tác
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
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
        @endpermission
        @permission(['administrator', 'admin'])
        <li {{ setOpen('tool') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-pencil-square-o"></i>
                <span class="menu-text"> Tool Server </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                @permission(['administrator'])
                <li {{ setActive('tool/payment') }}>
                    <a href="{{route('tool.payment')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Cấu hình kênh thanh toán
                    </a>

                    <b class="arrow"></b>
                </li>
                <li {{ setActive('tool/roles') }}>
                    <a href="{{route('tool.roles')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Danh sách role
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('tool/createAdmin') }}>
                    <a href="{{route('createAdmin.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tạo User
                    </a>

                    <b class="arrow"></b>
                </li>

                <li {{ setActive('system/taixiu/create') }}>
                    <a href="{{route('system.taixiu.create')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Tool tài xỉu
                    </a>

                    <b class="arrow"></b>
                </li>
                @endpermission
                <li {{ setActive('tool/sendEmail/create') }}>
                    <a href="{{route('tool.sendEmail.create')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Gửi email cho người dùng
                    </a>

                    <b class="arrow"></b>
                </li>

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

                <li {{ setActive('tool/crashTableAlarm') }}>
                    <a href="{{route('crashTableAlarm.index')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Quản lý cảnh báo và kẹt bàn
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
        @endpermission
        @permission(['administrator'])
        <li {{ setOpen('system') }}>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text"> Tương tác hệ thống </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">

                <li {{ setActive('system/ipLock') }}>
                    <a href="{{route('system.ipLock')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Khóa IP
                    </a>

                    <b class="arrow"></b>
                </li>

            </ul>
        </li>
        @endpermission
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
