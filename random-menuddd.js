jQuery(document).ready(function ($) {
    console.log('JavaScript is loaded');  // �f�o�b�O�p�̃��b�Z�[�W

    $('#random-menu-button').click(function (e) {
        e.preventDefault();  // �f�t�H���g�̓����h��
        console.log('Button clicked');  // �f�o�b�O�p�̃��b�Z�[�W

        $.ajax({
            url: ajax_object.ajaxurl,  // WordPress��AJAX URL
            type: 'POST',
            data: {
                action: 'random_menu'
            },
            success: function (response) {
                console.log('Received Data: ', response);  // �f�o�b�O���̒ǉ�
                if (response.success) {
                    $('#random-menu-result').html(response.data.menu); // menu�v���p�e�B��\��
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
