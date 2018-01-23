<?php
return call_user_func (function(){

	// initialize

	/** コンフィグオブジェクト */
	$conf = new stdClass;

    /** サイト名 */
	$conf->name = 'Plum';
	/** コピーライト表記 */
	$conf->copyright = 'Pickles 2 Project';

	/** プレビューサーバ定義 */
    $conf->preview_server = array(
		array(
			'name'=>'preview1',
			'path'=>'./../repos/preview1/',
			'url'=>'http://preview1.localhost/'
		),
		array(
			'name'=>'preview2',
			'path'=>'./../repos/preview2/',
			'url'=>'http://preview2.localhost/'
		),
		array(
			'name'=>'preview3',
			'path'=>'./../repos/preview3/',
			'url'=>'http://preview3.localhost/'
		),
	);

	/** gitコンフィグオブジェクト */
	$conf->git = new stdClass;

	// リポジトリのパス
	$conf->git->repository = './../repos/master/';

	// プロトコル
	// https/git
	$conf->git->protocol="https";

	// ホスト
	$conf->git->host="github.com";

	// url
	$conf->git->url="github.com/hk-r/px2-sample-project.git";

	// ユーザ名
	$conf->git->username="hoge";

	// パスワード
	$conf->git->password="fuga";




    return $conf;
});
