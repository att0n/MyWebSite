<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>UserList</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/theme.min.css" rel="stylesheet">
<?php
    $loginUser = session('loginUserKey');
?>
<script type="text/javascript">
	function sample(id) {
		if(window.confirm("ID:"+id+" を削除しますか？")){
			location.href = "./delete?id="+ id;
		}
	}
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
		<div>
			<h1 class="text-center">User list</h1>
		</div>
		<div class="col-sm-10 col-xs-offset-1">
			<hr>
		</div>

		<div class="col-xs-10 col-xs-offset-1">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>User name</th>
						<th>Complate rate</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					@foreach ($userList as $user)
					<tr>
						<th>{{ $user->id }}</th>
						<td>{{ $user->name }}</td>
						<td><?php echo $have_chara->get($user->id); ?>／{{ $all_chara }}</td>
						<td>
							<a href="./detail?id={{ $user->id }}" class="btn btn-primary">Detail</a>
							@if($loginUser->id == 1)
								<a href="./update?id={{ $user->id }}" class="btn btn-success">Update</a>
								<a onclick="sample({{ $user->id }})" class="btn btn-danger">Delete</a>
							@else if($loginUser->id == $user->id)
								<a href="./update?id={{ $user->id }}" class="btn btn-success">Update</a>
							@endif
						</td>
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
