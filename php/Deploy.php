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
					
					// git fetch
					if ( !exec( 'git fetch origin', $output) ) {

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
	public function set_deploy($preview_server_name, $to_branch) {

		$output = "";

		foreach ( $this->conf->preview_server as $preview_server ) {

			if ( $preview_server->name == $preview_server_name ) {

				// ディレクトリ移動
				chdir( __DIR__ );
				chdir( $preview_server->path );

				// 現在のブランチ取得
				$to_branch_rep = str_replace("origin/", "", $to_branch);
				if ( !exec( 'git branch --contains', $output) ) {

					// ** TODO ： エラー処理 ** //

				}

				var_dump($output);

				$now_branch = str_replace("* ", "", $output);

				// 現在のブランチと選択されたブランチが異なる場合は、ブランチを切り替える
				if ( $now_branch == $to_branch_rep ) {

					if ( !exec( 'git checkout -b ' . $to_branch_rep, $output) ) {

						// ** TODO ： エラー処理 ** //

					}
				}

				// git pull
				if ( !exec( 'git pull origin ' . $to_branch_rep ) ) {

					// ** TODO ： エラー処理 ** //

				}
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
