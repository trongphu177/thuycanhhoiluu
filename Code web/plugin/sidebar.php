<div class="sidebar-menu">

    <div class="sidebar-header">
        <div class="logo">
            <img src="../img/bk.png" height="50px">
        </div>
        <div class="text-brand">
            <h3>Hệ Thống</h3><h5>Giám Sát Trực Tuyến</h5>
        </div>
    </div>

    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="<?php if ($menu == 'temp') echo 'active';?>">
                        <a href="?menu=temp"><i class="ti-widget"></i><span>Nhiệt Độ</span></a>
                    </li>
                    <li class="<?php if ($menu == 'hum') echo 'active';?>">
                        <a href="?menu=hum"><i class="ti-view-grid"></i><span>Độ Ẩm Không Khí</span></a>
                    </li>
                    <li class="<?php if ($menu == 'light') echo 'active';?>">
                        <a href="?menu=light"><i class="ti-blackboard"></i><span>Cường Độ Ánh Sáng</span></a>
                    </li>
                    <li class="<?php if ($menu == 'tds') echo 'active';?>">
                        <a href="?menu=tds"><i class="ti-paint-bucket"></i><span>Nồng độ hòa tan</span></a>
                    </li>
                    <li class="<?php if ($menu == 'ph') echo 'active';?>">
                        <a href="?menu=ph"><i class="ti-thought"></i><span>Độ PH</span></a>
                    </li>
                    <li class="<?php if ($menu == 'control') echo 'active';?>">
                        <a href="?menu=control"><i class="ti-control-shuffle"></i><span>Điều Khiển Thiết Bị</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

</div>