<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CupsuleToy</title>
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
				<p class="navbar-text" style="color: #FFFFFF;">- {{ $loginUser->name }} さん！</p>
				<a onclick="logout()" class="btn btn-default navbar-btn navbar-right" role="button">Logout</a>
				<a href="./userList" class="btn btn-default navbar-btn navbar-right" role="button">List</a>
				<a href="./create" class="btn btn-default navbar-btn navbar-right" role="button">Create</a>
			</div>
		</div>
	</nav>

	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<h1 class="text-center">Capsule toy</h1>
		</div>
	</div>

	<div class="col-sm-8 col-sm-offset-2">
		<div class="pull-right">

			@if($loginUser->id == 1)
				<a href="./characterCreate" class="btn btn-default" role="button">Add Character</a>
			@endif
			<a href="./characterList?id={{ $loginUser->id }}" class="btn btn-default" role="button">Character List</a>
		</div>
	</div>
	<div class="col-sm-8 col-sm-offset-2">

		<hr>
		<h3><p class="small">回したい回数のボタンを押してください</p></h3>
		<div class="btn-group btn-group-justified" role="group">
			<a href="./gatya?num=1&id={{ $loginUser->id }}" class="btn btn-default" role="button">1回</a>
		</div>
		<div class="col-xs-12" style="height: 1em;"></div>
		<div class="btn-group btn-group-justified" role="group">
			<a href="./gatya?num=10&id={{ $loginUser->id }}" class="btn btn-default" role="button">10回</a>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
