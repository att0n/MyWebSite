<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Result</title>

<!-- レアリティ演出css -->
<?php
if($rate == "ssr"){
    echo "<link href='./css/rarelitySSR.css' rel='stylesheet'>";
}elseif ($rate == "sr"){
    echo "<link href='./css/rarelitySR.css' rel='stylesheet'>";
}else{
    echo "<link href='./css/rarelityR.css' rel='stylesheet'>";
}
?>
<!-- レアリティ演出css -->

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/theme.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/animations.css">

</head>
<body>

	<form action="./gatyaResult" method="post">
	{!! csrf_field() !!}

		<?php for($i=0; $i<count($result); $i++){ ?>
			<input type="hidden" class="form-control" name="result<?php echo $i ?>" value="<?php echo $result[$i]->id ?>">
		<?php } ?>

		<div class="parent">
			<div class="inner">
				<div class="floating">
					<h1>▼ CLICK</h1>
				</div>
				<button type="submit" class="btn btn-default btn-group btn-group-justified">result</button>
			</div>
		</div>

	</form>

</body>
</html>