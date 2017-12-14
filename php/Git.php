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
	public function get_branch_list() {
		
		chdir($this->options["path"]);
		exec('git branch', $output);

		return $output;
	}


}

?>