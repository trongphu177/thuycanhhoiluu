<div class="main-content-inner">

    <div class="sales-report-area mt-4 mb-4">
        <div class="row">

            <div class="col-md-4">
                <div class="single-report mb-xs-30">
                    <div id="g1" class="gauge"></div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex">
                            <text class="title-statistic">Thống Kê Nồng Độ Trong Ngày</text>
                        </div>
                        <div class="market-status-table">
                            <div class="table-responsive">
                                <table class="dbkit-table">
                                    <tbody>
                                        <tr>
                                            <td><b>Lớn Nhất</b></td>
                                            <td><b>Nhỏ Nhất</b></td>
                                            <td><b>Trung Bình</b></td>
                                        </tr>
                                        <tr>
                                            <td><p id="max-tdsValue"></p> - <p id="max-tdsDate"></p></td>
                                            <td><p id="min-tdsValue"></p> - <p id="min-tdsDate"></p></td>
                                            <td><p id="ave-tdsValue"></p></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div id="graph"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-sm-flex">
                        <text class="title-data">Dữ Liệu Nồng Độ</text>
                    </div>
                    <div class="table-responsive">
                        <table id="tb_data" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td><b>STT</b></td>
                                    <td><b>Nồng Độ</b></td>
                                    <td><b>Ngày</b></td>
                                    <td><b>Giờ</b></td>
                                </tr>
                            </thead>
                            <tbody id="data_tds">
                                <?php
                                    $query = "SELECT * FROM tds ORDER BY id DESC";
                                    $result = mysqli_query($conn, $query);
                                    $number = 1;
                                    while ($row = mysqli_fetch_assoc($result)):
                                        echo "<tr>";
                                        echo "<td>{$number}</td>";
                                        echo "<td>{$row['value']} Ppm</td>";
                                        echo "<td>".date('d/m/Y', strtotime($row['date']))."</td>";
                                        echo "<td>".date('H:i:s', strtotime($row['date']))."</td>";
                                        echo "</tr>";
                                        $number += 1;
                                    endwhile;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>




<?php
    $query = "SELECT value FROM tds ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($result);
    $result = $result['value'];
?>

<script type="text/javascript">

    var tds = '<?php echo $result; ?>';
    function get_tds() {
        $.get("../sensor/tds/ajax/get_tds.php?last=true", function(data){
            tds = data;
        });
    }

    function gauge_tds() {
        var g1 = new JustGage({
            id: "g1", 
            value: tds, 
            min: 0,
            max: 1000,
            title: "Nồng Độ Hiện Tại",
            label: "Ppm",
            decimals: 0,
            pointer: true,
            pointerOptions: {
                    toplength: -15,
                    bottomlength: 10,
                    bottomwidth: 12,
                    color: '#8e8e93',
                    stroke: '#ffffff',
                    stroke_width: 3,
                    stroke_linecap: 'round'},
            gaugeWidthScale: 0.54,
            counter: true   });
        setInterval(function(){g1.refresh(tds);}, 1000);
    }

    setInterval(get_tds, 1000);
</script>

<script type="text/javascript">
    function statistic_tds() {
        $.ajax({
            url: '../sensor/tds/ajax/statistic_tds.php',
            type: 'POST',
            data: {name: 'test'},
            dataType: 'html',
            success: function(data) {
                var vals = data.split(',');
                $(document).ready(function(){
                    $("#max-tdsValue").html(vals[0] + " Ppm");
                    $("#max-tdstDate").html(vals[1]);
                    $("#min-tdsValue").html(vals[2] + " Ppm");
                    $("#min-tdsDate").html(vals[3]);
                    $("#ave-tdsValue").html(vals[4] + " Ppm");
                }); 
            }
        });
    }

    setInterval(statistic_tds, 1000);
</script>

<!--
<script type="text/javascript">
    $(document).ready(function(){
        $.ajax({
            url: '../temp/ajax/data_temp.php',
            type: 'POST',
            dataType: 'html',
            success: function(data) {
                $('#data_temp').html(data);
            }
        })
    })
</script>
-->


<script type="text/javascript">
    $(document).ready(function() {
        $("#tb_data").DataTable({
            "language": {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
                "sInfo":         "Đang xem từ _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                }
            },
            "pagingType": "full_numbers",

        })
    });
</script>




<script type="text/javascript">
    window.onload = function() {
        get_tds();
        gauge_tds();
        statistic_tds();
        //refreshData();
    }
</script>




<script src="../js/highcharts.js"></script>
<script type="text/javascript">

$(document).ready(function() {
 
    Highcharts.setOptions({
        time: {useUTC: false}
    });

    $.ajax({
        url: "../sensor/tds/includes/data.php?re=1",
        type: 'get',
        dataType: 'json',
        success: function(json) {
            Highcharts.chart('graph',{
        
                chart: {
                  //renderTo: 'container',
                  events: {
                    load: function() {series = this.series[0];
                    }
                  },                  
                  height: '310px',
                  type: 'spline',
                  style: {
                    fontFamily: 'Arial, sans-serif'
                  }
                },

               // time: {useUTC: false},
                exporting: {
                    csv: {
                        dateFormat: '%H:%M:%S %d/%m/%Y',
                        decimalPoint: String,
                    },
                    filename: 'Nồng Độ',
                    buttons: {
                        contextButton: {
                            menuItems: ['downloadPNG','downloadJPEG', 'downloadSVG', 'downloadPDF','separator','downloadCSV','downloadXLS','viewData','openInCloud']
                        }
                    } 
                },
                legend: {
                    layout: 'vertical',
                    align: 'center',
                    verticalAlign: 'bottom'
                },
                plotOptions: {
                    spline: {
                        //lineColor: '#5AE3F8',
                        lineWidth: 2,
                    },
                    series: {
                        marker: {
                            enabled: false,              /* enabled/disabled the point */
                        },

                    },
                },
               title: {
                    text: 'Đồ Thị Nồng Độ Trong Ngày',
                    style: {
                        color: '#999999',
                        fontWeight: 'bold',
                        fontSize: '20px',
                    }
                },                      
               tooltip: {
                    valueSuffix: ' lux',
                    backgroundColor: 'rgba(219,219,216,0.8)',
                    crosshairs: false,
                    split: false,
                },
               xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {second: '%H:%M',},
                    title: {
                        text: null,
                    },
                    //gridLineWidth: 1,

                },
               yAxis: {
                    type: 'linear',
                    title: {
                        text: 'Nồng Độ (ppm)',
                        style: {
                            color: '#2E2E2E',
                            fontFamily: 'Arial',
                            fontWeight: 'bold'
                        }
                    },
               },       
                series: [{
                    name: 'Nồng Độ',
                    data: json
                }]
            })  
        }
    });
 
    var vals;
    var time_temp;
    $.get("../sensor/tds/includes/data.php?re=2", function(json) {
        vals = json.split(",");
        time_temp = parseInt(vals[0]);
    });

    setInterval(function() {
        $.get("../sensor/tds/includes/data.php?re=2", function(json){
            vals = json.split(",");
            var time = parseInt(vals[0]);
            var value = parseFloat(vals[1]);
            if (get_time() != time) {
                series.addPoint([time, value], true, false);
                set_time(time);
            }
        });
    }, 2000);

    function get_time() {return time_temp;};
    function set_time(x) {time_temp = x;};

});
</script>


