<?php

class Plum_Deploy
{
	private $dep;
	private $path;
	private $list;
	private $options;
	private $conf;

	/**
	 * コンストラクタ
	 * @param $options = オプション
	 */
	public function __construct($options) {
		$this->options = $options;
	}

	/**
	 * オプション配列を取得する
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * デプロイする
	 */
	public function set_deploy($server_name) {

		$output = "";

		// config情報取得
		$this->get_config();

		foreach ($this->conf->preview_server as $preview_server) {

			if ($preview_server->name == $server_name) {

				// ディレクトリ移動
				chdir(__DIR__);
				chdir($preview_server->path);

				// git セットアップ
				exec('git init', $output);
				
				// git urlのセット
				$url = $this->conf->git->protocol . "://" . $this->conf->git->url;
				exec('git remote add origin ' . $url, $output);
				
				// git pull
				exec('git pull origin master');
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
