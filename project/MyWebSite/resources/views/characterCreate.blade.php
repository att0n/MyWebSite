<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CreateUser</title>
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
				<p class="navbar-text" style="color: #FFFFFF;">- {{$loginUser->name}} さん！</p>
				<a onclick="logout()" class="btn btn-default navbar-btn navbar-right" role="button">Logout</a>
				<a href="./userList" class="btn btn-default navbar-btn navbar-right" role="button">List</a>
				<a href="./create" class="btn btn-default navbar-btn navbar-right" role="button">Create</a>
			</div>
		</div>
	</nav>

	<div class="row">
		<div>
			<h1 class="text-center">Add character</h1>
		</div>
		<div class="col-sm-10 col-xs-offset-1">
			@if (count($errors) > 0)
    			<div class="alert alert-danger">
        			<ul>
            			@foreach ($errors->all() as $error)
                			<li>{{ $error }}</li>
            			@endforeach
        			</ul>
    			</div>
			@endif
			<hr>
		</div>

		<div class="col-xs-12">
			<form class="form-horizontal" action="./addChara" method="post" enctype="multipart/form-data">
			{!! csrf_field() !!}

				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputSelect">Rarity</label>
					<div class="col-sm-7">
						<select class="form-control" name="chara_rarity">
							<option value="1">R</option>
							<option value="2">SR</option>
							<option value="3">SSR</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputName">Name</label>
					<div class="col-sm-7">
						<input class="form-control" placeholder="Character Name" name="chara_name">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputFile">Image</label>
					<div class="col-sm-7">
						<input type="file" name="chara_image1">
						<p class="help-block">256*256pxの画像</p>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputBirthday">Birthday</label>
					<div class="col-sm-7">
						<input type="date" class="form-control" id="InputBirthday" placeholder="Birthday" name="chara_birth">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputSelect">Blood</label>
					<div class="col-sm-7">
						<select class="form-control" name="chara_blood">
							<option>A</option>
							<option>O</option>
							<option>B</option>
							<option>AB</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-7 col-md-offset-3">
						<button type="submit" class="btn btn-default btn-block">Add</button>
					</div>
				</div>

			</form>
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
