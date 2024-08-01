jQuery(document).ready(function ($) {
    console.log('JavaScript is loaded');  // デバッグ用のメッセージ

    $('#random-menu-button').click(function (e) {
        e.preventDefault();  // デフォルトの動作を防ぐ
        console.log('Button clicked');  // デバッグ用のメッセージ

        $.ajax({
            url: ajax_object.ajaxurl,  // WordPressのAJAX URL
            type: 'POST',
            data: {
                action: 'random_menu'
            },
            success: function (response) {
                console.log('Received Data: ', response);  // デバッグ情報の追加
                if (response.success) {
                    $('#random-menu-result').html(response.data.menu); // menuプロパティを表示
                } else {
                    $('#random-menu-result').html('Error: Could not retrieve menu.');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('AJAX Error: ' + textStatus + ': ' + errorThrown);
            }
        });
    });
});
