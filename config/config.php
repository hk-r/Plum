<?php
return call_user_func (function(){

	// initialize

	/** コンフィグオブジェクト */
	$conf = new stdClass;

    /** サイト名 */
	$conf->name = 'Plum';
	/** コピーライト表記 */
	$conf->copyright = 'Pickles 2 Project';

	/** プレビューサーバ定義 **/
    $conf->preview_server = array(
		array(
			'name'=>'preview1',
			'path'=>'./../../preview1'
		),
		array(
			'name'=>'preview2',
			'path'=>'./../../preview2'
		),
		array(
			'name'=>'preview3',
			'path'=>'./../../preview3'
		),
	);

	/** gitコンフィグオブジェクト */
	$conf->git = new stdClass;

	// リポジトリのパス
	$conf->git->repository = "./../../../../work/pickles2/px2-extract-ogp";

	// プロトコル
	// https/git
	$conf->git->protocol="https";

	// ホスト
	$conf->git->host="github.com";

	// url
	$conf->git->url="github.com/hk-r/px2-extract-ogp.git";

	// ユーザ名
	$conf->git->username="hoge";

	// パスワード
	$conf->git->password="fuga";



    
    return $conf;
});