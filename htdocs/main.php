<?php

//require_once("./../htdocs/.px_execute.php");
require_once("./../php/Git.php");

$conf = include( './../config/config.php' );
$conf = json_decode( json_encode( $conf ) );

$git = new Plum_Git(
	array(
		'path'=>$conf->git->repository
	)
);
	
$branch_list = $git->get_branch_list();

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
<td><button type="button" class="btn btn-default">状態</button></td>
<td>
<select class="form-control">
<?php foreach( $branch_list as $branch ){ ?>
<option value="<?=htmlspecialchars($branch) ?>"><?=htmlspecialchars($branch) ?></option>
<?php } ?>
</select>
</td>
<td><button type="button" class="btn btn-default">反映</button></td>
</tr>
<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>