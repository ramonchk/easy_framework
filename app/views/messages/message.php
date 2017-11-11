<?php $time = explode(' ', microtime()); $time = $time[0]; $time = str_replace("0000", "", $time); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title><?php echo @$title; ?></title>
	<?php load_css("highlight/highlight.pack.css"); ?>
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
	.message{ padding-left: 60px; padding-right: 60px; }
	.right{ text-align: right;}
	.error{ border: 7px solid red !important; }
	.error h1{ background-color: red; }
	.warning{ border: 7px solid yellow !important; }
	.warning h1{ background-color: yellow; color: black; }
	.success{ border: 7px solid green !important; }
	.success h1{ background-color: green; }
	.info{ border: 7px solid blue !important; }
	.info h1{ background-color: blue; }
	@media only screen and (max-width: 680px) {
		#content{ width: 98%; }
		.message{padding-left: 0; padding-right: 0;}
	}
</style>
<body>
	<div id="content">
		<div class="<?php echo @$class; ?>">
			<h1><?php echo @$title; ?></h1>
			<div class="message">
				<h3><?php echo @$message; ?></h3>
			</div>
		</div>
		<br/>
		<div class="right">
			<strong>
				Easy Framework <?php echo EF_V; ?>
			</strong> 
				- 
			<strong>
				PHP <?php echo phpversion(); ?>
			</strong> 
				- <?php echo translate_message("welcomeloadindex") ?>
			<strong>
				<?php echo $time; ?>
				<?php echo translate_message("welcomesecondsindex") ?>.
			</strong>
		</div>	</div>


	<?php load_js("highlight/highlight.pack.js"); ?>
	<script>
		hljs.initHighlightingOnLoad();
	</script>
</body>
</html>