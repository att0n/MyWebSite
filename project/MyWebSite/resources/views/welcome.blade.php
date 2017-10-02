<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css"
	rel="stylesheet">
	<link href="./css/theme.min.css" rel="stylesheet">

</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbarEexample9">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand"> Capsule toy</a>
			</div>
			<div class="collapse navbar-collapse" id="navbarEexample9">
				<p class="navbar-text" style="color: #FFFFFF;">- Welcome to GUEST ！</p>
			</div>
		</div>
	</nav>

	<div class="row">
		<div>
			<h1 class="text-center">Login</h1>
		</div>
		<div class="col-sm-10 col-xs-offset-1">
			<hr>
		</div>
	</div>

	<form class="form-horizontal" action="./main" method="post">
		{!! csrf_field() !!}
		<div class="form-group">
			<label class="col-sm-3 control-label" for="InputEmail">Login ID</label>
			<div class="col-sm-7">
				<input type="text" class="form-control" id="InputEmail"
					placeholder="login id" name="login_id">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" for="InputPassword">Password</label>
			<div class="col-sm-7">
				<input type="password" class="form-control" id="InputPassword"
					placeholder="password" name="pass">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-7">
				<button type="submit" class="btn btn-default">Login</button>
			</div>
		</div>
	</form>

	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script
		src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
