<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Result</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

	<div class="col-xs-12" style="height: 10em;"></div>
	<div class="col-xs-10 col-xs-offset-1">
		<table class="center-block">
			<tbody class="col-xs-10 col-xs-offset-1">
				<tr>

				<?php for($i=0; $i<count($result); $i++){ ?>
				<td><a data-toggle="modal" data-target="#sampleModal<?php echo $i ?>">
					<img src="./images/100x100/<?php echo $result[$i]->chara_image ?>" class="img-circle">
				</a></td>
				<?php if($i == 4){ echo "</tr><tr>";} }?>

				</tr>
			</tbody>
		</table>
		<div class="col-xs-12" style="height: 5em;"></div>
		<div class="btn-group btn-group-justified" role="group">
			<a href="./mainScreen" class="btn btn-default" role="button">Main screen</a>
		</div>
	</div>


	<!-- モーダル・ダイアログ -->
	<?php for($i=0; $i<count($result); $i++){ ?>
	<div class="modal fade" id="sampleModal<?php echo $i ?>" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span>×</span>
				</button>
				<h4 class="modal-title"><?php echo $result[$i]->chara_name ?></h4>
			</div>
			<div class="modal-body">
				<div class="media">
					<a class="media-left"> <img src="./images/<?php echo $result[$i]->chara_image ?>"></a>
					<div class="media-body">
						<div class="well well-lg">ID : <?php echo $result[$i]->id ?></div>
						<div class="well well-lg">Birthday：<?php echo $result[$i]->chara_birth ?></div>
						<div class="well well-lg">Blood：<?php echo $result[$i]->chara_blood ?></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	</div>
	<?php } ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
