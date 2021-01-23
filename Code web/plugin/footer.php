<footer>
    <div class="footer-area">
        <p>© Created By <b>Nguyen Trong Phu</b></p><br>
        <p>Project: <b>Online Monitoring System<b></p>
    </div>
</footer>

<!-- bootstrap 4 js -->
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap/bootstrap4-toggle.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/metisMenu.min.js"></script>
<script src="../js/jquery.slimscroll.min.js"></script>
<script src="../js/jquery.slicknav.min.js"></script>

<!-- others plugins -->
<script src="../js/plugins.js"></script>
<script src="../js/scripts.js"></script>

<!-- Clock -->
<script type="text/javascript">
    function getTime() {
        var time = new Date();
        var numDay = time.getDay();
        var arrDay = ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ 7'];
        for (i = 0; i < arrDay.length; i++) {
            if (numDay == i) {
                numDay = arrDay[i];
                break;
            }
        }
        var day = time.getDate();
        var month = time.getMonth() + 1;
        var year = time.getFullYear();
        var hr = time.getHours();
        var min = time.getMinutes();
        var sec = time.getSeconds();
        day = ((day < 10) ? "0" : "") + day;
        month = ((month < 10) ? "0" : "") + month;
        hr = ((hr < 10) ? "0" : "") + hr;
        min = ((min < 10) ? "0" : "") + min;
        sec = ((sec < 10) ? "0" : "") + sec;
        return "Hôm nay là: " + numDay + " " + day + "/" + month + "/" + year + " " + hr + ":" + min + ":" + sec;
    }
    function showTime() {
        var vnclock = document.getElementById("vnclock");
        if (vnclock != null)
            vnclock.innerHTML = getTime();
        setTimeout("showTime()", 1000);
    }
    window.setTimeout("showTime()", 1000);
</script>