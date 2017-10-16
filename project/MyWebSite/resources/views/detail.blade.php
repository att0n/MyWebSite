<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detail</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/theme.min.css" rel="stylesheet">
<?php
    $loginUser = session('loginUserKey');
?>

<script type="text/javascript">
	function logout() {
		if(window.confirm("ログアウトしますか？")){
			location.href = "./logout";
		}
	}
	function reset(id) {
		if(window.confirm("達成率リセットしますか？")){
			location.href = "./reset?id="+ id;
		}
	}
</script>
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbarEexample9">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="./mainScreen"> Capsule toy</a>
			</div>

			<div class="collapse navbar-collapse" id="navbarEexample9">
				<p class="navbar-text" style="color: #FFFFFF;">- <?php echo $loginUser->name?> さん！</p>
				<a onclick="logout()" class="btn btn-default navbar-btn navbar-right" role="button">Logout</a>
				<a href="./userList" class="btn btn-default navbar-btn navbar-right" role="button">List</a>
				<a href="./create" class="btn btn-default navbar-btn navbar-right" role="button">Create</a>
			</div>
		</div>
	</nav>

	<div class="row">
		<div>
			<h1 class="text-center">Detail
			</h1>
		</div>
		<div class="col-sm-10 col-xs-offset-1">
			<hr>
		</div>
	</div>

	<div class="row">
		<form class="form-horizontal">

			<div class="form-group">
				<label class="col-sm-5 control-label" for="InputEmail">Login ID</label>
				<div class="col-sm-5">
					<p class="form-control-static text-center"><?php echo $user->login_id ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="InputUserName">User name</label>
				<div class="col-sm-5">
					<p class="form-control-static text-center"><?php echo $user->name ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="InputUserName">Birthday</label>
				<div class="col-sm-5">
					<p class="form-control-static text-center"><?php echo $user->birth_date ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="InputAddDay">Create date</label>
				<div class="col-sm-5">
					<p class="form-control-static text-center"><?php echo $user->create_date ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="InputAddDay">Update date</label>
				<div class="col-sm-5">
					<p class="form-control-static text-center"><?php echo $user->update_date ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 control-label" for="InputUserName">Complate rate</label>
				<div class="col-sm-5">
					<p class="form-control-static text-center"><?php echo $have_chara ?>／<?php echo $all_chara ?>

					<?php if($loginUser->id == 1 || $loginUser->id == $user->id){ ?>
						<a onclick="reset(<?php echo $user->id ?>)" class="btn btn-warning btn-xs" role="button">Reset</a>
					<?php } ?>

					</p>
				</div>
			</div>
		</form>

	</div>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
