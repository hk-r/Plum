<?php

//require_once("./../htdocs/.px_execute.php");
require_once( __DIR__ . "./../php/Git.php");
require_once( __DIR__ . "./../php/Deploy.php");

/** 設定情報の取得 **/
$conf = include( __DIR__ . './../config/config.php' );
$conf = json_decode( json_encode( $conf ) );

/** Gitリポジトリ取得 **/
$git = new Plum_Git(
	array(
		'path'=>$conf->git->repository
	)
);
$branch_list = $git->get_branch_list();

/** デプロイ実行処理 **/
if (isset($_POST["reflect"])) {
	$reflect = htmlspecialchars($_POST["reflect"], ENT_QUOTES, "UTF-8");
	
	// Deploy
	$deploy = new Plum_Deploy(
		array(
			// オプション
		)
	);

	$ret = $deploy->set_deploy(
		'preview1'
	);

	echo '<script type="text/javascript">alert("deploy done");</script>';
}



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Plum</title>
		<!-- BootstrapのCSS読み込み -->
		<link href="common/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery読み込み -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- BootstrapのJS読み込み -->
		<script src="common/bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Plum</a>
				</div>
			</div>
		</nav>

		<div class="container">
			<form method="POST" action="">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>server</th>
							<th>状態</th>
							<th>branch</th>
							<th>反映</th>
						</tr>
					</thead>
					<tbody>
<?php foreach( $conf->preview_server as $prev_row ){ ?>
<tr>
<th scope="row"><?=htmlspecialchars($prev_row->name) ?></th>
<td><button type="submit" class="btn btn-default" value="状態" name="state">状態</button></td>
<td>
<select class="form-control">
<?php foreach( $branch_list as $branch ){ ?>
<option value="<?=htmlspecialchars($branch) ?>"><?=htmlspecialchars($branch) ?></option>
<?php } ?>
</select>
</td>
<td><button type="submit" class="btn btn-default" value="反映" name="reflect">反映</button></td>
</tr>
<?php } ?>
					</tbody>
				</table>
			</form>
		</div>
	</body>
</html>