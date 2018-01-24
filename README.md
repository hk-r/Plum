hk-r/app-plum
======================

ウェブプロジェクトをプレビュー環境へデプロイするツールです。

## 導入方法 - Setup
### 1． gitリポジトリをclone
```
$ mkdir /path/to/your/project
$ cd /path/to/your/project
$ git clone https://github.com/hk-r/app-plum.git
```

### 2． config.phpを設定する
```
<?php
return call_user_func (function(){

	/* (中略) */

	/** プレビューサーバ定義 */
	$conf->preview_server = array(

		// プレビューサーバの数だけ設定する
		//
		//   string 'name':
		//     - プレビューサーバ名(任意)
		//   string 'path':
		//     - プレビューサーバ(デプロイ先)のパス
		//       `htdocs/main.php` からの相対パスを設定する
		//   string 'url':
		//     - プレビューサーバのURL
		//       Webサーバのvirtual host等で設定したURL
		//
		array(
			'name'=>'preview1',
			'path'=>'./../repos/preview1/',
			'url'=>'http://preview1.localhost/'
		),
	);

	/* (中略) */
	
	// リポジトリのパス
	// ウェブプロジェクトのリポジトリパスを設定。
	$conf->git->repository = './../repos/master/';

	// プロトコル
	// ※現在はhttpsのみ対応
	$conf->git->protocol="https";

	// ホスト
	// Gitリポジトリのhostを設定。
	$conf->git->host="github.com";

	// url
	// Gitリポジトリのhostを設定。
	$conf->git->url="github.com/hk-r/px2-sample-project.git";

	// ユーザ名
	// Gitリポジトリのユーザ名を設定。
	$conf->git->username="hoge";

	// パスワード
	// Gitリポジトリのパスワードを設定。
	$conf->git->password="fuga";

    return $conf;
});

```

## 更新履歴 - Change log
### app-plum x.x (yyyy年mm月dd日)
- Initial Release.

## ライセンス - License
MIT License

## 作者 - Author
- (C)Kyota Hiyoshi hiyoshi-kyota@imjp.co.jp