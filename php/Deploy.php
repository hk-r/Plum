<?php

class Plum_Deploy
{
	private $dep;
	private $path;
	private $dist_list;
	private $options;
	private $conf;

	/**
	 * コンストラクタ
	 * @param $options = オプション
	 */
	public function __construct($options) {
		$this->options = $options;

		// config情報取得
		$this->get_config();
	}

	/**
	 * オプション配列を取得する
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * initialize処理
	 * デプロイ先として指定されたフォルダの初期化処理。
	 * gitのリポジトリを設定する。
	 * @param $repository_url = リポジトリのURL
	 * @param $dist_path = デプロイ先のパス
	 */
	public function init($repository_url, $dist_path) {

		$output = "";

		if ( strlen($dist_path) ) {

			// デプロイ先のディレクトリが無い場合は作成
			if ( !file_exists( __DIR__ . $dist_path) ) {
				// 存在しない場合

				// ディレクトリ作成
				if ( !mkdir( __DIR__ . $dist_path, 0777) ) {
					// ディレクトリが作成できない場合

					// ** TODO ： エラー処理 ** //

				}
			}
			
			// 「.git」フォルダが存在すれば初期化済みと判定
			if ( !file_exists( __DIR__ . $dist_path . "/.git") ) {
				// 存在しない場合
				
				chdir( __DIR__ );

				// ディレクトリ移動
				if ( chdir( $dist_path ) ) {

					// git セットアップ
					if ( !exec('git init', $output) ) {

						// ** TODO ： エラー処理 ** //

					}
					
					// git urlのセット
					$url = $this->conf->git->protocol . "://" . $this->conf->git->url;
					if ( !exec('git remote add origin ' . $url, $output) ) {

						// ** TODO ： エラー処理 ** //

					}
					
					// git pull
					if ( !exec( 'git pull origin master', $output) ) {

						// ** TODO ： エラー処理 ** //

					}
				}
			}
		}		
	}

	/**
	 * デプロイする
	 */
	public function set_deploy($server_name) {

		$output = "";

		foreach ( $this->conf->preview_server as $preview_server ) {

			if ( $preview_server->name == $server_name ) {

				// ディレクトリ移動
				chdir( __DIR__ );
				chdir( $preview_server->path );

				// git セットアップ
				exec( 'git init', $output );
				
				// git urlのセット
				$url = $this->conf->git->protocol . "://" . $this->conf->git->url;
				exec( 'git remote add origin ' . $url, $output );
				
				// git pull
				exec( 'git pull origin master' );
			}
		}

		return $output;
	}

	/**
	 * config情報を取得する
	 */
	private function get_config() {
		
		/** 設定情報の取得 **/
		$conf = include( __DIR__ . './../config/config.php' );
		$conf = json_decode( json_encode( $conf ) );

		$this->conf = $conf;

		return $this->conf;
	}


}
