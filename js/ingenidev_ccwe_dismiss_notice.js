jQuery(document).ready(function($) {
    $('body').on('click', '#ingenidev-dismiss-notice', function() {
        $.ajax({
            type: 'POST',
            url: ingenidev_ccwe_ajax_obj.ajax_url,
            data: {
                action: ingenidev_ccwe_ajax_obj.action
            },
            success: function() {
                $('#ingenidev-welcome-notice').hide();
            }
        });
    });
});

