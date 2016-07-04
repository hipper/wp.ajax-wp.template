(function(){
    var wp      = window.wp,
        wpNonce = '#_wpnonce';

    function commentSuccess(data) {}
    function commentError(data) {}

    function ajaxCheckDuplications(data) {
        wp.ajax.send('sajari_score', {
            data: {
                nonce: $(wpNonce).val(),
                post_id: $('#post_ID').val()
            },
            success: callbackSuccess,
            error:   callbackError
        });
    }

    function displayLoadingPanel() {
        // Prepare panel
        var $panel = $('.migrationPanel');

        var panelContent = wp.template('migration-content');

        $panel.find('.panel-content').html( panelContent({
            status: "World",
            content: '<div class="mt-spinner"><div class="mt-spinner-inner"><span></span></div></div>',
            actions: ''
        }));

        // Display panel
        $panel.removeClass('hidden');
    }

    // Take over submissions.
    $("some-button").click(function(e){
        e.preventDefault();

        // Loading panel -- wp.template
        displayLoadingPanel();

        // Disable button
        $(this).prop('disabled', true);

        // Check duplication and update interface -- wp.ajax.send
        ajaxCheckDuplications(true);
    });
})(jQuery);