<?php

class Plum_Git
{
	private $gt;
	private $path;
	private $list;
	private $options;

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
	 * ブランチリストを取得する
	 */
	public function get_parent_branch_list() {
		
		$output_array = array();

		chdir( $this->options["path"] );
		exec( 'git branch -r', $output );

		foreach ($output as $key => $value) {
			if( strpos($value, '/HEAD') !== false ){
				continue;
			}
			$output_array[] = trim($value);
		}

		return $output_array;
	}

	/**
	 * リポジトリの状態を取得する
	 */
	public function get_child_repo_status() {
		
		

		return $output;
	}

	/**
	 * 現在のブランチを取得する
	 */
	public function get_child_current_branch($path) {

		$output = "";
		$ret = "";
		
		// ディレクトリ移動
		chdir( __DIR__ );
		chdir( $path );

		exec( 'git branch --contains', $output );

		$now_branch;
		foreach ( $output as $value ) {
			// 「*」の付いてるブランチを現在のブランチと判定
			if ( strpos($value, '*') !== false ) {
				$value = str_replace("* ", "", $value);
				$now_branch = $value;
			}
		}

		$ret = str_replace("* ", "", $now_branch);
		$ret = trim($ret);

		return $ret;
	}


}
