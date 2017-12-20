var lockId = "lockId";

/*
 * 画面操作を無効にする
 */
function lockScreen(id) {

    // 現在画面を覆い隠すためのDIVタグを作成する
    var divTag = $('<div />').attr("id", id);

    // スタイルを設定
    divTag.css("z-index", "999")
          .css("position", "absolute")
          .css("top", "0px")
          .css("left", "0px")
          .css("right", "0px")
          .css("bottom", "0px")
          .css("opacity", "0.8");

    // BODYタグに作成したDIVタグを追加
    $('body').append(divTag);
}

/*
 * 画面操作無効を解除する
 */
function unlockScreen(id) {

    // 画面を覆っているタグを削除する
    $("#" + id).remove();
}


$(function($){
	$(window).load(function(){

		$('#init_btn').on('click', function() {

			// 画面ロック
			lockScreen(lockId);

			var $form = $('<form>').attr({
				action : '',
				method: 'post'
			});
			$('body').append($form);

			var $input = $('<input>').attr({
				type : 'hidden',
				name : 'initialize',
				value: 'value'
			});
			
			$form.append($input);
			$form.submit();
		});

		$('.reflect').on('click', function() {
			
			// 画面ロック
			lockScreen(lockId);

			var val = this.id;
			var preview = val.replace('reflect_', '');
			var select_branch = $('#branch_list_' + preview).val();

			var $form = $('<form>').attr({
				action : '',
				method: 'post'
			});
			$('body').append($form);

			// 反映ボタン押下イベント
			var $input_reflect = $('<input>').attr({
				type : 'hidden',
				name : 'reflect',
				value: 'value'
			});

			// previewサーバ
			var $input_preview = $('<input>').attr({
				type : 'hidden',
				name : 'preview',
				value: preview
			});

			// 選択したブランチ名
			var $input_branch = $('<input>').attr({
				type : 'hidden',
				name : 'select_branch',
				value: select_branch
			});
			
			$form.append($input_reflect);
			$form.append($input_preview);
			$form.append($input_branch);
			$form.submit();
		});
	})
});
