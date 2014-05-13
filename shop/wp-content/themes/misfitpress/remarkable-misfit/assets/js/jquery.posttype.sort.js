/* jQuery Sorter (Enables Sorting of Portfolio, Service, Slider, Team and Quote items)
-------------------------------------------------------------------------------------------*/

jQuery(document).ready(function ($) {
    var postList = $('#post-list');
    postList.sortable({
        update: function (event, ui) {
            $('#loading-animation').show();
            opts = {
                url: ajaxurl,
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data: {
                    action: 'post_sort',
                    order: postList.sortable('toArray').toString()
                },
                success: function (response) {
                    $('#loading-animation').hide();
                    return;
                },
                error: function (xhr, textStatus, e) {
                    alert('There was an error saving the updates');
                    $('#loading-animation').hide();
                    return;
                }
            };
            $.ajax(opts);
        }
    });
});