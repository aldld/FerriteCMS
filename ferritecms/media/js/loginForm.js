var editLinkText = '';

$(document).ready(function() {
    editLinkText = $('.ferritecms_editlink').html();
    // Load the login form, hidden by default
    if ($('#ferritecms_loginform').length == 0) {
        $.get(baseURL + 'ferritecms/media/html/login.html', function(data) {
            $('body').append(data);
        });
    }
});

/**
 * Function handling the login form
 */
function editorLogin(event) {
    if ($(event.target).is('.ferritecms_leaveeditor')) {
        leaveEditorMode();
        return false;
    }
    
    if (!$.cookie('fcms_admin')) {
        $('#ferritecms_obscure').show();
        
        $loginform = $('#ferritecms_loginform');
        $loginform.css({
            'top': ($(window).height()/2) - ($loginform.outerHeight()/2),
            'left': ($(window).width()/2) - ($loginform.outerWidth()/2)
        });
        $loginform.fadeIn(100);
        $('#ferritecms_password').focus();
        $('#ferritecms_loginform').submit(function() {
            $.post(baseURL + 'ferritecms/ajax/login.php', {
                'password': $('#ferritecms_password').val()
            }, function(data) {
                if (data) {
                    $('#ferritecms_loginform, #ferritecms_obscure').hide();
                    editorInit();
                } else { // login falied
                    alert('Login failed');
                }
            });
            return false;
        });
        $('#ferritecms_logincancel').click(function() {
            $('#ferritecms_loginform, #ferritecms_obscure').hide();
            return false;
        });
    }
    
    return false;
}