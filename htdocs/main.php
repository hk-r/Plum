<?php
ini_set('display_errors', 0);

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
$ret = json_decode($git->get_parent_branch_list());
$branch_list = array();
$branch_list = $ret->branch_list;

/** イニシャライズ処理 **/
if ( isset($_POST["initialize"]) ) {

	// Deploy
	$deploy = new Plum_Deploy(
		array(
			// オプション
		)
	);

	// プレビューサーバの初期化処理
	$ret = $deploy->init();
	$ret = json_decode($ret);

	if ( $ret->status ) {
		echo '<script type="text/javascript">alert("initialize done");</script>';
	} else {
		// エラー処理
		echo '
			<script type="text/javascript">
				console.error("' . $ret->message . '");
				alert("initialize faild");
			</script>';
	}
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
	$ret = json_decode($ret);

	if ( $ret->status ) {
		echo '<script type="text/javascript">alert("deploy done");</script>';
	} else {
		// エラー処理
		echo '
			<script type="text/javascript">
				console.error("' . $ret->message . '");
				alert("deploy faild");
			</script>';
	}
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
						<th>プレビュー</th>
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
<?php $current_branch = json_decode($git->get_child_current_branch($prev_row->path)); ?>
<?php if(str_replace("origin/", "", $branch) == $current_branch->current_branch) { ?>
<option value="<?=htmlspecialchars($branch) ?>" selected><?=htmlspecialchars($branch) ?></option>
<?php } else { ?>
<option value="<?=htmlspecialchars($branch) ?>"><?=htmlspecialchars($branch) ?></option>
<?php } ?>
<?php } ?>
</select>
</td>
<td><button type="button" id="reflect_<?=htmlspecialchars($prev_row->name) ?>" class="reflect btn btn-default" value="反映" name="reflect">反映</button></td>
<td><a href="<?=htmlspecialchars($prev_row->url) ?>" class="btn btn-default" target="_blank">プレビュー</a></td>
</tr>
<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>