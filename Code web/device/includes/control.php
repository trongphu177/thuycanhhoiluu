<div class="main-content-inner device">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <?php
                    $query = "SELECT*FROM mode WHERE id = 1";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $mode = $row['value'];
                    echo '<input type="checkbox" ';
                    if ($mode==1)
                        echo 'checked ';
                    echo 'data-toggle="toggle" data-on="Thủ công" data-off="Tự động" data-onstyle="success" data-offstyle="danger" onchange="change_mode()">';
                ?>

                <div class="d-sm-flex">
                    <text id="setpoint-title" class="title-statistic <?php if ($mode==1) echo 'hide'?>">Cài Đặt Giá Trị Ngưỡng</text>
                </div>
                <div id="setpoint" class="market-status-table <?php if ($mode==1) echo 'hide'?>">
                    <div class="table-responsive">
                        <table class="dbkit-table">
                            <thead>
                                <tr>
                                    <td>STT</td>
                                    <td>Cảm biến</td>
                                    <td>Giá trị min</td>
                                    <td>Giá trị max</td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT*FROM setpoint ORDER BY id";
                                    $result = mysqli_query($conn, $query);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)):
                                        $status[$i] = $row['status'];
                                        echo "<tr data-toggle='modal' data-target='#Modal-".$i."'>";
                                        echo "<td>$i</td>";
                                        echo "<td>{$row['name']}</td>";
                                        echo "<td id='value-min-".$i."'>{$row['min']}</td>";
                                        echo "<td id='value-max-".$i."'>{$row['max']}</td>";
                                        
                                        echo "</tr>";
                                        $i+=1;
                                    endwhile
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
                    $query = "SELECT*FROM setpoint ORDER BY id";
                    $result = mysqli_query($conn, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        echo '<div class="modal fade" id="Modal-'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">';
                        echo '<div class="modal-dialog modal-dialog-centered" role="document">';
                        echo '<div class="modal-content">';
                        echo '<div class="modal-header">';
                        echo '<h5 class="modal-title" id="exampleModalLongTitle">Cài Đặt Ngưỡng '.$row['name'].'</h5>';
                        echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                        echo '<span aria-hidden="true">&times;</span>';
                        echo '</button>';
                        echo '</div>';
                        echo '<form>';

                            echo '<div class="modal-body">';
                                echo '<div class="form-group">';
                                    echo '<label for="max">Giá trị max:</label>';
                                    echo '<input type="text" class="form-control" id="max-'.$i.'" placeholder="'.$row['max'].'" required>';
                                echo '</div>';

                                echo '<div class="form-group">';
                                    echo '<label for="min">Giá trị min:</label>';
                                    echo '<input type="text" class="form-control" id="min-'.$i.'" placeholder="'.$row['min'].'" required>';
                                echo '</div>';
                            echo '</div>';

                            echo '<div class="modal-footer">';
                                echo '<button id="'.$i.'" type="submit" class="btn btn-primary" data-dismiss="modal" onclick="setpoint(this.id)">Lưu thay đổi</button>';
                            echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        $i+=1;
                    endwhile
                ?>

                <div class="d-sm-flex">
                    <text class="title-statistic">Bật Tắt Các Thiết Bị</text>
                </div>
                <div class="market-status-table">
                    <div class="table-responsive">
                        <table class="dbkit-table">
                            <thead>
                                <tr>
                                    <td>STT</td>
                                    <td>Tên Thiết Bị</td>
                                    <td>Trạng Thái</td>
                                    <td>Điều Khiển</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT*FROM device ORDER BY id";
                                    $result = mysqli_query($conn, $query);
                                    $i = 1;
                                    $status = array();
                                    while ($row = mysqli_fetch_assoc($result)):
                                        $status[$i] = $row['status'];
                                        echo "<tr>";
                                        echo "<td>$i</td>";
                                        echo "<td>{$row['name']}</td>";
                                        echo "<td>";

                                            echo '<span id="status_pin_'.$row['id'].'_off" class="badge badge-success '; 
                                                if ($row['status'] == 0) 
                                                    echo "hide";
                                            echo '">Đang Bật</span>';

                                            echo '<span id="status_pin_'.$row['id'].'_on" class="badge badge-secondary ';
                                                if ($row['status'] == 1)
                                                    echo "hide";
                                            echo '">Đang Tắt</span>';

                                        echo "</td>";
                                        echo "<td>";

                                            echo '<button id="btn_'.$row['id'].'_off" class="btn loading btn-success btn-sm ';
                                                if ($row['code'] == 1 || $mode == 0)
                                                    echo "hide";
                                            echo '" role="button" onclick="onOff(this.id)"><b>Tắt Thiết Bị</b></button>';

                                            echo '<button id="btn_'.$row['id'].'_on" class="btn loading btn-danger btn-sm ';
                                                if ($row['code'] == 0 || $mode == 0)
                                                    echo "hide";
                                            echo '" role="button" onclick="onOff(this.id)"><b>Bật Thiết Bị</b></button>';

                                            echo '<button id="btn_'.$row['id'].'_mode" class="btn btn-sm ';
                                                if ($mode == 1)
                                                    echo "hide";
                                            echo '" role="button" disabled><b>Tự động</b></button>';

                                        echo "</td>";
                                        echo "</tr>";
                                        $i+=1;
                                    endwhile
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function setpoint(id){
        var max = $("#max-"+id).val();
        var min = $("#min-"+id).val();
        if (max == "" || min == "") {
            alert("Vui lòng nhập giá trị vào !");
        } else if (max < min) {
            alert("Giá trị max phải lớn hơn giá trị min !");
        } else {
            $.ajax({
                type: 'POST',
                url: "../device/ajax/change_setpoint.php",
                data: "id="+id+"&max="+max+"&min="+min,
                success: function(result){
                    var vals = result.split("-");
                    $("#value-max-"+vals[0]).html(vals[1]);
                    $("#value-min-"+vals[0]).html(vals[2]);
                }
            });
        }
    }

    function onOff(id){
        temp_array = id.split('_');
        var url = "../device/ajax/on_off.php?" + temp_array[0] + "_" + temp_array[1] + "=" + temp_array[2];
        $.ajax({
            url: url,
            success: function(result){
                console.log("---pin " + temp_array[1] + " " + temp_array[2]);
            }
        });
    }

    function change_onOff(){
        setInterval(function(){
            $.ajax({
                url: '../device/ajax/pin_onoff_read.php',
                type: 'POST',
                data: {refresh: 1},
                dataType: 'html',
                success: function(data){
                    var vals = data.split(",");
                    mode_array = vals[0].split(":");
                    if (mode_array[1] == "0"){
                        for (i=1; i<vals.length-1; i++){
                            temp_array = vals[i].split(":");
                            var btn_on = "btn_" + temp_array[0] + "_on";
                            var btn_off = "btn_" + temp_array[0] + "_off";
                            var btn_mode = "btn_" + temp_array[0] + "_mode";
                            $("#" + btn_off).addClass('hide');
                            $("#" + btn_on).addClass('hide');
                            $("#" + btn_mode).removeClass('hide');
                            $("#setpoint-title").removeClass('hide');
                            $("#setpoint").removeClass('hide');
                        }
                    } else if (mode_array[1] == "1"){
                        $("#setpoint-title").addClass('hide');
                        $("#setpoint").addClass('hide');
                        for (i=1; i<vals.length-1; i++){
                            temp_array = vals[i].split(":");
                            var btn_on = "btn_" + temp_array[0] + "_on";
                            var btn_off = "btn_" + temp_array[0] + "_off";
                            var btn_mode = "btn_" + temp_array[0] + "_mode";
                            $("#" + btn_mode).addClass('hide');
                            if (temp_array[1] == "1"){
                                $("#" + btn_off).removeClass('hide');
                                $("#" + btn_on).addClass('hide');
                            } else if (temp_array[1] == "0"){
                                $("#" + btn_off).addClass('hide');
                                $("#" + btn_on).removeClass('hide');
                            }
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log("ERROR");
                }
            });
        }, 2000)
    }


    $(document).ready(function() {
        $('.btn').on('click', function() {
            var $this = $(this);
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> Loading...';
            if ($(this).html() !== loadingText) {
                $this.data('original-text', $(this).html());
                $this.html(loadingText);
            }
            setTimeout(function() {
                $this.html($this.data('original-text'));
            }, 2000);
        });
    })

   function change_status(){
        setInterval(function(){
            $.ajax({
                url: '../device/ajax/pin_onoff_status.php',
                type: 'POST',
                data: {refresh: 1},
                dataType: 'html',
                success: function(data){
                    var vals = data.split(",");
                    for (i=0; i<vals.length-1; i++){
                        temp_array = vals[i].split(":");
                        var pin_on = "status_pin_" + temp_array[0] + "_on";
                        var pin_off = "status_pin_" + temp_array[0] + "_off";
                        if (temp_array[1] == "1"){
                            $("#" + pin_off).removeClass('hide');
                            $("#" + pin_on).addClass('hide');
                        } else if (temp_array[1] == "0"){
                            $("#" + pin_off).addClass('hide');
                            $("#" + pin_on).removeClass('hide');
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError){
                    console.log("ERROR");
                }
            });
        }, 1500);
    }

    function change_mode(){
        
        $.ajax({
            url: '../device/ajax/change_mode.php?last=true',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                if (data == 1)
                    console.log("thủ công");
                if (data == 0)
                    console.log("tự động");
            }
        });
    }

    function onLoad() {
        change_onOff();
        change_status();
    }
    
    window.onload = onLoad();

</script>