
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="./css/theme.min.css" rel="stylesheet">
<style type="text/css">
img.chara{width:100px;height:auto;}
</style>
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
			<?php if($searchFlag == false){ ?>
				<p class="small text-center">達成率 <?php echo $chara->count() ?>／<?php echo $all_chara?></p>
			<?php }else{ ?>
				<p class="small text-center">検索結果：<?php echo $chara->count() ?>件</p>
			<?php } ?>
			</h3>
		</div>
		<div class="col-sm-10 col-xs-offset-1">

			<form action="./characterSearchID?userID=<?php echo $loginUser->id?>" method="post">
			{!! csrf_field() !!}
				<div class="input-group">
					<span class="input-group-addon">ID</span>
					<input type="text"class="form-control" placeholder="character ID" name="chara_id">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default">Search</button>
					</span>
				</div>
			</form>

			<div class="col-xs-12" style="height: 1em;"></div>

			<form action="./characterSearchName?userID=<?php echo $loginUser->id?>" method="post">
			{!! csrf_field() !!}
				<div class="input-group">
					<span class="input-group-addon">name</span>
					<input type="text" class="form-control" placeholder="character name" name="chara_name">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default">Search</button>
					</span>
				</div>
			</form>

			<div class="col-xs-12" style="height: 1em;"></div>

			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					Rarity
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="./searchRarity?rarity=3">SSR</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="./searchRarity?rarity=2">SR</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="./searchRarity?rarity=1">R</a></li>
				</ul>
			</div>

			<hr>
		</div>
	</div>


	<div class="col-xs-10 col-xs-offset-1">
		<table>
			<tbody>
				<tr>
				<?php for($i=0; $i<count($chara); $i++){ ?>

						<td><a href="./characterDetail?id=<?php echo $chara[$i]->chara_id?>&uId=<?php echo $loginUser->id ?>" class="thumbnail">

						<img src="<?php echo $chara[$i]->chara_image?>" class="chara">
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
