<?php

class Plum_Deploy
{
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
	 */
	public function init() {
		$current_dir = realpath('.');

		$output = "";
		$result = array('status' => true,
						'message' => '');

		foreach ( $this->conf->preview_server as $preview_server ) {

			try {

				if ( strlen($preview_server->path) ) {

					// デプロイ先のディレクトリが無い場合は作成
					if ( !file_exists( $preview_server->path) ) {
						// 存在しない場合

						// ディレクトリ作成
						if ( !mkdir( $preview_server->path, 0777) ) {
							// ディレクトリが作成できない場合

							// エラー処理
							throw new Exception('Creation of preview server directory failed.');
						}
					}

					// 「.git」フォルダが存在すれば初期化済みと判定
					if ( !file_exists( $preview_server->path . "/.git") ) {
						// 存在しない場合

						// ディレクトリ移動
						if ( chdir( $preview_server->path ) ) {

							// git セットアップ
							exec('git init', $output);

							// git urlのセット
							$url = $this->conf->git->protocol . "://" . urlencode($this->conf->git->username) . ":" . urlencode($this->conf->git->password) . "@" . $this->conf->git->url;
							exec('git remote add origin ' . $url, $output);

							// git fetch
							exec( 'git fetch origin', $output);

							// git pull
							exec( 'git pull origin master', $output);

							chdir($current_dir);
						} else {
							// プレビューサーバのディレクトリが存在しない場合

							// エラー処理
							throw new Exception('Preview server directory not found.');
						}
					}
				}

			} catch (Exception $e) {

				$result['status'] = false;
				$result['message'] = $e->getMessage();

				chdir($current_dir);
				return json_encode($result);
			}

		}

		$result['status'] = true;

		return json_encode($result);
	}

	/**
	 * デプロイする
	 * @param preview_server_name = プレビューサーバの名称
	 * @param to_branch = 切り替えるブランチ
	 */
	public function set_deploy($preview_server_name, $to_branch) {
		$current_dir = realpath('.');

		$output = "";
		$result = array('status' => true,
						'message' => '');

		foreach ( $this->conf->preview_server as $preview_server ) {

			try {

				if ( trim($preview_server->name) == trim($preview_server_name) ) {

					$to_branch_rep = trim(str_replace("origin/", "", $to_branch));

					// ディレクトリ移動
					if ( chdir( $preview_server->path ) ) {

						// 現在のブランチ取得
						exec( 'git branch', $output);

						$now_branch;
						$already_branch_checkout = false;
						foreach ( $output as $value ) {

							// 「*」の付いてるブランチを現在のブランチと判定
							if ( strpos($value, '*') !== false ) {

								$value = trim(str_replace("* ", "", $value));
								$now_branch = $value;

							} else {

								$value = trim($value);

							}

							// 選択された(切り替える)ブランチがブランチの一覧に含まれているか判定
							if ( $value == $to_branch_rep ) {
								$already_branch_checkout = true;
							}
						}

						// 現在のブランチと選択されたブランチが異なる場合は、ブランチを切り替える
						if ( $now_branch !== $to_branch_rep ) {

							if ($already_branch_checkout) {
								// 選択された(切り替える)ブランチが既にチェックアウト済みの場合

								exec( 'git checkout ' . $to_branch_rep, $output);

							} else {
								// 選択された(切り替える)ブランチがまだチェックアウトされてない場合

								exec( 'git checkout -b ' . $to_branch_rep . ' ' . $to_branch, $output);
							}
						}

						// git fetch
						exec( 'git fetch origin', $output );

						// git pull
						exec( 'git pull origin ' . $to_branch_rep, $output );

					} else {
						// プレビューサーバのディレクトリが存在しない場合

						// エラー処理
						throw new Exception('Preview server directory not found.');
					}

				}

			} catch (Exception $e) {

				$result['status'] = false;
				$result['message'] = $e->getMessage();

				chdir($current_dir);
				return json_encode($result);
			}

		}

		$result['status'] = true;

		chdir($current_dir);
		return json_encode($result);
	}

	/**
	 * 初期化済みチェック
	 */
	public function get_already_initialized() {
		$output = "";
		$result = array('status' => true,
						'message' => '');

		foreach ( $this->conf->preview_server as $preview_server ) {

			try {

				if ( strlen($preview_server->path) ) {

					// デプロイ先のディレクトリが無い場合は作成
					if ( file_exists( $preview_server->path) ) {
						// 存在する場合

						// 「.git」フォルダが存在すれば初期化済みと判定
						if ( file_exists( $preview_server->path . "/.git") ) {
							// 存在する場合

							$result['status'] = true;
							$result['already_init'] = true;
							return json_encode($result);
						}
					}
				}

			} catch (Exception $e) {

				$result['status'] = false;
				$result['message'] = $e->getMessage();

				return json_encode($result);
			}

		}

		$result['status'] = true;
		$result['already_init'] = false;
		return json_encode($result);
	}

	/**
	 * config情報を取得する
	 */
	private function get_config() {

		/** 設定情報の取得 **/
		$conf = include( __DIR__ . '/../config/config.php' );
		$conf = json_decode( json_encode( $conf ) );

		$this->conf = $conf;

		return $this->conf;
	}

}
