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
$branch_list = $git->get_parent_branch_list();

/** イニシャライズ処理 **/
if ( isset($_POST["initialize"]) ) {

	// Deploy
	$deploy = new Plum_Deploy(
		array(
			// オプション
		)
	);

	// プレビューサーバの数分の初期化処理
	foreach ($conf->preview_server as $value) {
		$ret = $deploy->init(
			$conf->git->repository,
			$value->path
		);
	}
	
	echo '<script type="text/javascript">alert("initialize done");</script>';
}

/** デプロイ実行処理 **/
if ( isset($_POST["reflect"]) ) {
	$reflect = htmlspecialchars( $_POST["reflect"], ENT_QUOTES, "UTF-8" );
	$preview = htmlspecialchars( $_POST["preview"], ENT_QUOTES, "UTF-8" );
	$select_branch = htmlspecialchars( $_POST["select_branch"], ENT_QUOTES, "UTF-8" );
	
	// Deploy
	$deploy = new Plum_Deploy(
		array(
			// オプション
		)
	);

	$ret = $deploy->set_deploy(
		$preview,
		$select_branch
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
		<script src="common/scripts/common.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Plum</a>
				</div>
				<div class="collapse navbar-collapse" id="nav_target">
					<ul class="nav navbar-nav navbar-right">
						<!-- Nav ドロップダウン -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Nav <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a id="init_btn">Initialize</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
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
<?php foreach( $conf->preview_server as $key => $prev_row ){ ?>
<tr>
<th scope="row"><?=htmlspecialchars($prev_row->name) ?></th>
<td><button type="button" id="state_<?=htmlspecialchars($prev_row->name) ?>" class="btn btn-default" value="状態" name="state">状態</button></td>
<td>
<select id="branch_list_<?=htmlspecialchars($prev_row->name) ?>" class="form-control" name="branch_form_list">
<?php foreach( $branch_list as $branch ){ ?>
<?php if(str_replace("origin/", "", $branch) == $git->get_child_current_branch($prev_row->path)) { ?>
<option value="<?=htmlspecialchars($branch) ?>" selected><?=htmlspecialchars($branch) ?></option>
<?php } else { ?>
<option value="<?=htmlspecialchars($branch) ?>"><?=htmlspecialchars($branch) ?></option>
<?php } ?>
<?php } ?>
</select>
</td>
<td><button type="button" id="reflect_<?=htmlspecialchars($prev_row->name) ?>" class="reflect btn btn-default" value="反映" name="reflect">反映</button></td>
</tr>
<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>