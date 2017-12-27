<?php

class Plum_Git
{	
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
		$result = array('status' => true,
						'message' => '');

		try {

			// ディレクトリ移動
			chdir( __DIR__ );

			if ( chdir( $this->options["path"] )) {
			
				// fetch
				exec( 'git fetch', $output );

				// ブランチの一覧取得
				exec( 'git branch -r', $output );

				foreach ($output as $key => $value) {
					if( strpos($value, '/HEAD') !== false ){
						continue;
					}
					$output_array[] = trim($value);
				}

				$result['branch_list'] = $output_array;

			} else {
				// プレビューサーバのディレクトリが存在しない場合
							
				// エラー処理
				throw new Exception('Preview server directory not found.');
			}

		} catch (Exception $e) {

			$result['status'] = false;
			$result['message'] = $e->getMessage();

			return json_encode($result);
		}
		
		$result['status'] = true;

		return json_encode($result);
	}

	/**
	 * リポジトリの状態を取得する
	 */
	public function get_child_repo_status() {
		
		
	}

	/**
	 * 現在のブランチを取得する
	 */
	public function get_child_current_branch($path) {

		$output = "";
		$result = array('status' => true,
						'message' => '');
		
		try {

			// ディレクトリ移動
			chdir( __DIR__ );

			if ( chdir( $path ) ) {

				// ブランチ一覧取得
				exec( 'git branch', $output );

				$now_branch;
				foreach ( $output as $value ) {
					// 「*」の付いてるブランチを現在のブランチと判定
					if ( strpos($value, '*') !== false ) {
						$value = str_replace("* ", "", $value);
						$now_branch = $value;
					}
				}

				$ret = str_replace("* ", "", $now_branch);
				$result['current_branch'] = trim($ret);

			} else {
				// プレビューサーバのディレクトリが存在しない場合
							
				// エラー処理
				throw new Exception('Preview server directory not found.');
			}
			
		} catch (Exception $e) {

			$result['status'] = false;
			$result['message'] = $e->getMessage();

			return json_encode($result);
		}

		$result['status'] = true;

		return json_encode($result);
	}
}
