<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Update</title>
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
				<p class="navbar-text" style="color: #FFFFFF;">- <?php echo $loginUser->name?> さん！</p>
				<a onclick="logout()" class="btn btn-default navbar-btn navbar-right" role="button">Logout</a>
				<a href="./userList" class="btn btn-default navbar-btn navbar-right" role="button">List</a>
				<a href="./create" class="btn btn-default navbar-btn navbar-right" role="button">Create</a>
			</div>
		</div>
	</nav>

	<div class="row">
		<div>
			<h1 class="text-center">Update</h1>
		</div>
		<div class="col-sm-10 col-xs-offset-1">
			<hr>
		</div>

		<div class="col-xs-12">
			<form class="form-horizontal" action="./userUpdate?id=<?php echo $user->id ?>" method="post">
			{!! csrf_field() !!}

				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputEmail">Login ID</label>
					<div class="col-sm-7"><p><?php echo $user->login_id ?></p></div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputPassword">Password</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="InputPassword" name="pass" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputPassword2">Password(確認)</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="InputPassword2" name="pass2" placeholder="Password(確認)">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputUserName">User name</label>
					<div class="col-sm-7">
						<input class="form-control" id="InputUserName" placeholder="user name" value="<?php echo $user->name ?>" name="name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label" for="InputUserName">Birthday</label>
					<div class="col-sm-7">
						<input type="date" class="form-control" id="InputBirthday" name="birth">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-7 col-md-offset-3">
						<button type="submit" class="btn btn-default btn-block">更新</button>
					</div>
				</div>

			</form>
		</div>
	</div>

	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
