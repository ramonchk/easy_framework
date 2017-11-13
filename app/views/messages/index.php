<?php
	include_once("../../../app/config.php");
	include_once("../../../core/functions.php");
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo translate_message("restrictedaccesstitle"); ?></title>
</head>
<style>
	body{ background-color: #ECECEC; }
	#content{
		margin-top: 5%;
		width: 90%;
		margin-left: auto;
		margin-right: auto;
		-webkit-box-shadow: -5px 5px 10px 3px rgba(0,0,0,0.6);
		-moz-box-shadow: -5px 5px 10px 3px rgba(0,0,0,0.6);
		box-shadow: -5px 5px 10px 3px rgba(0,0,0,0.6);
		background-color: white;
		padding: 15px;
		box-sizing: border-box;
	}
	h1{
		margin: 0;
		color: white;
		line-height: 50px;
		padding-left: 15px;
		padding-right: 15px;
		padding-bottom: 7px;
		background-color: black;
	}
	.error{ border: 7px solid red !important; }
	.error h1{ background-color: red; }
	.message{ padding-left: 60px; padding-right: 60px; }
	@media only screen and (max-width: 680px) {
		#content{ width: 98%; }
		.message{padding-left: 0; padding-right: 0;}
	}
</style>
<body>
	<div id="content">
		<div class="error">
			<h1><?php echo translate_message("restrictedaccesstitle"); ?></h1>
			<div class="message">
				<h3>
					<?php echo translate_message("restrictedaccessmessage"); ?>
				</h3>
			</div>
		</div>
		</div>
</body>
</html>