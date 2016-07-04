<?php
/**
 * wp.ajax demo
 */
add_action('wp_ajax_sajari_score', 'ajaxSajariScore');
function ajaxSajariScore() {
    $nonce  = isset($_REQUEST["nonce"]) ? $_REQUEST["nonce"] : "";
    $postId = intval($_REQUEST['post_id']);

    // ...do some stuff in PHP

    $toReply = [
        'body'  => (!empty($duplicateBody)) ? $duplicateBody : 0
    ];

     wp_send_json_success($toReply);
}

/**
 * wp.template demo
 */
function migrationPanelHtml() {
    ?>
    <div class="mwn-migration-tool hidden">
        <h2 class="mt-title">
            <span class="dashicons"></span>
            <span class="mt-status-title"></span>
        </h2>

        <div class="panel-content">
            <!-- template content -->
        </div>
    </div>

    <!-- Status template -->
    <script id="tmpl-migration-content" type="text/html">
            <p class="mt-status-message">
                {{data.status}}
            </p>

            <div class="mt-content">
                {{{data.content}}}
            </div>

            <div class="mt-actions">
                <# _.each( data.actions, function( action, key ) { #>
                    <# if ('note' === key) { #>
                        <div class="mt-action-note"><p>{{action}}</p></div>
                    <# } #>

                    <# if ('minor' === key) { #>
                        <div class="mt-minor-actions"><button class="button button-hero">{{action}}</button></div>
                    <# } #>

                    <# if ('major' === key) { #>
                        <div class="mt-major-action"><button class="button button-primary button-hero">{{action}}</button></div>
                    <# } #>
                <# }); #>

                <div class="clear"></div>
            </div>
    </script>
    <?php
}