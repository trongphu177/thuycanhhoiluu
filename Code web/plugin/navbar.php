<div class="main-content">

<div class="header-area">
    <div class="row align-items-center">

        <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
                <span></span>
                <span></span>
                <span></span>     
            </div>
             <?php
				$query1 = "SELECT * FROM rain ORDER BY id DESC LIMIT 1";
				$result = mysqli_query($conn, $query1);
				$row = mysqli_fetch_assoc($result);
				if ($row['value'] == "1")
                echo '<span id="weather"><img src="../img/storm.svg" width="75px" height="35px" align="left" style=""></span>';
               	if ($row['value'] == "0")
                echo '<span id="weather"><img src="../img/sun.svg" width="85px" height="35px" align="left" style=""></span>';
			
			?>         
        </div>

        <div class="col-md-6 col-sm-4 clearfix">
            <div class="pull-right" id="vnclock"></div>
        </div>	
        
    </div>
</div>

<script>
	setInterval(function(){
		$.ajax({
			url: "../plugin/rain.php",
			type: "POST",
			dataType: 'html',
			success: function(data){
				if (data == "1") {
					$("#weather").html("<img src='../img/storm.svg' width='75px' height='35px' align='left' style=''>");
				}
				if (data == "0")
					$("#weather").html("<img src='../img/sun.svg' width='85px' height='35px' align='left' style=''>");
				}
		})
	},2000)
</script>