
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/theme.min.css" rel="stylesheet">
<?php
    $loginUser = session('loginUserKey');
?>
<title>CharacterList</title>
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
			<h1 class="text-center">Character List</h1>
			<h3>
				<p class="small text-center">達成率 100%</p>
			</h3>
		</div>
		<div class="col-sm-10 col-xs-offset-1">
			<div class="input-group">
				<span class="input-group-addon">ID</span>
					<input type="text"class="form-control" placeholder="character ID" name="chara_id">
					<span class="input-group-btn">
					<button type="button" class="btn btn-default">Search</button>
				</span>
			</div>
			<div class="col-xs-12" style="height: 1em;"></div>
			<div class="input-group">
				<span class="input-group-addon">name</span>
					<input type="text" class="form-control" placeholder="character name" name="chara_name">
					<span class="input-group-btn">
					<button type="button" class="btn btn-default">Search</button>
				</span>
			</div>
			<hr>
		</div>
	</div>


	<div class="col-xs-10 col-xs-offset-1">
		<table>
			<tbody>
				<tr>
				<?php for($i=0; $i<count($chara); $i++){ ?>

					<td><a href="./characterDetail?id=<?php echo $chara[$i]->id?>" class="thumbnail">
					<img src="./images/<?php echo $chara[$i]->chara_image?>">
					</a></td>

				<?php } ?>
				</tr>
			</tbody>
		</table>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
