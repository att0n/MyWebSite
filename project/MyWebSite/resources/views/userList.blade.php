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
				<p class="navbar-text" style="color: #FFFFFF;">- <?php echo $loginUser->name?> さん！</p>
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

					<?php for($i=0; $i<count($userList); $i++){?>
					<tr>
						<th><?php echo $userList[$i]->id?></th>
						<td><?php echo $userList[$i]->name?></td>
						<td><?php echo $have_chara->get($userList[$i]->id); ?>／<?php echo $all_chara ?></td>
						<td>
							<a href="./detail?id=<?php echo $userList[$i]->id ?>" class="btn btn-primary">Detail</a>
							<?php if($loginUser->id == 1){ ?>
								<a href="./update?id=<?php echo $userList[$i]->id ?>" class="btn btn-success">Update</a>
								<a onclick="sample(<?php echo $userList[$i]->id?>)" class="btn btn-danger">Delete</a>
							<?php }else if($loginUser->id == $userList[$i]->id){ ?>
								<a href="./update?id=<?php echo $userList[$i]->id ?>" class="btn btn-success">Update</a>
							<?php } ?>
						</td>
					</tr>
					<?php }?>

				</tbody>
			</table>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
