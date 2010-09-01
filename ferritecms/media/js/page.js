function newPage() {
     var newPageOpen = false;
    $('.ferritecms_newpage').show();
    $('.ferritecms_newpage a').click(function() {
        // Get the parent ID
        var parentID = $(this).parent().attr('id').split('-')[1];
        
        // Display a dialog to ask for a page title/slug
        if (!newPageOpen) {
            newPageOpen = true;
            $.get(baseURL + 'ferritecms/ajax/pageInfo.php', {
                'type': 'new',
                'parent': parentID
            }, function(data) {
                $('body').append(data);
                $('.ferritecms_dialog').not(':first').remove();
                
                $('#ferritecms_obscure').show();
                
                $newform = $('#ferritecms_newform');
                
                $newform.css({
                    'top': ($(window).height()/2) - ($newform.outerHeight()/2),
                    'left': ($(window).width()/2) - ($newform.outerWidth()/2)
                });
                
                // When "cancel" is clicked
                $('#ferritecms_pinfocancel').click(function() {
                    $newform.remove();
                    $('#ferritecms_obscure').hide();
                    newPageOpen = false;
                    return false;
                });
                
                // Post the data to the server on form submit
                $newform.find('form').unbind('submit');
                $newform.find('form').submit(function() {
                    title = $('#ferritecms_pinfotitle').val();
                    slug = $('#ferritcms_pinfoslug').val();
                    parent = $('#ferritecms_pinfoparent').val();
                    
                    $.post(baseURL + 'ferritecms/ajax/newPage.php', {
                        'title': title,
                        'slug': slug,
                        'parent': parent
                    }, function(data) {
                        switch (data) {
                            case '0':
                                alert('Error sending values');
                                break;
                            
                            case '1':
                                alert('Page link already in use. Please choose another.');
                                break;
                            
                            case '2':
                                alert('All fields are required.');
                                break;
                            
                            default:
                                $newform.remove();
                                $('#ferritecms_obscure').hide();
                                newPageOpen = false;
                                $('#ferritecms_newparent-' + parent).before(data);
                                break;
                        }
                    });
                
                    return false;
                });
            });
        }
        
        return false;
    });
}

function editPageInfo() {
    
}