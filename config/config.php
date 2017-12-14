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
			'path'=>'/preview1'
		),
		array(
			'name'=>'preview2',
			'path'=>'/preview2'
		),
		array(
			'name'=>'preview3',
			'path'=>'/preview3'
		),
	);

	/** コンフィグオブジェクト */
	$conf->git = new stdClass;

	$conf->git->repository = "./../../../../work/pickles2/app-pickles2";
    
    return $conf;
});