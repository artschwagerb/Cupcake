<?php
//$endtime = microtime();
$endarray = explode(" ", microtime());
$endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime-$starttime; 
$totaltime = round($totaltime,5);
?>
<hr />
<div class="row">
	<div class="twelve columns">
		<div class="eight columns">
		Created by Brian... 
"It is always with the best intentions that the worst work is done." - Oscar Wilde
		</div>
		<div class="four columns">
                    <div class="alert-box">BETA Application, please <a href="support.php?prevpage='<?php echo $_SERVER['PHP_SELF']; ?>'">report any errors</a>.<br />
                        <div class="row">
                            <div class="six columns">
                                <div class="row">
                                    <p style="font-size: 9px; margin-bottom:0px;">Version: 2/29/12</p>
                                </div>
                            </div>
                            <div class="six columns">
                                <div class="row">
                                    <p style="font-size: 9px; margin-bottom:0px;">Load: <?php echo "$totaltime s"; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <p style="font-size: 9px; margin-bottom:0px;">Server: <?php echo $_SERVER['HTTP_HOST']; ?></p>
                        </div>
                    </div>
		</div>
	</div>
</div>

</div>
<!-- container -->




	<!-- Included JS Files -->
	<script src="javascripts/jquery.min.js"></script>
	<script src="javascripts/modernizr.foundation.js"></script>
	<script src="javascripts/foundation.js"></script>
	<script src="javascripts/app.js"></script>
</body>
</html>

