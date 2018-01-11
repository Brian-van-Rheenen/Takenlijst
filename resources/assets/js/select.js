$('body').click(function(e) {
    if (!$(e.target).closest('.dropdown-content').length){
        $('.dropdown-content').parent().find('.dropdown-content').css({
            'opacity' : '0',
            'max-height' : '0px'
        });
    }
});

$(document).on('click', '.select-dropdown', function(event)
{
    $(event.target).parent().find('.dropdown-content').css({
        'opacity' : '1',
        'max-height' : '250px'
    });

    var dropdown = $(event.target).parent().find('.dropdown-content > li');

    $(dropdown).each(function(i, obj) {
        if ($(obj).find('span').text() == $(event.target).parent().find('.select-dropdown').val())
        {
            $(this).addClass('selected');
        }
        else
        {
            $(this).removeClass('selected');
        }
    });
});