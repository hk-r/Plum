var lockId = "lockId";

/*
 * 
 */	
function set_reflect_num(obj) {
	
}

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

			lockScreen(lockId);

			var form = document.createElement( 'form' );
		
			document.body.appendChild( form );
			
			var input = document.createElement( 'input' );
			input.setAttribute( 'type', 'hidden' );
			input.setAttribute( 'name', 'initialize' );
			input.setAttribute( 'value', 'value' );
			
			form.appendChild( input );
			form.setAttribute( 'action', '' );
			form.setAttribute( 'method', 'post' );
			form.submit();
		});
	})
});
