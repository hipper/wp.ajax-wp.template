# wp.ajax + wp.template

WordPress has 2 handy JS functions `wp.ajax` and `wp.template`.

`wp.ajax` contains two methods currently, `wp.ajax.post()` and `wp.ajax.send()`

## wp.ajax.send( action[, options])
**File Location**: /wp-includes/js/wp-utils.js

**action**
*Type: String*
The action corresponds with the action callback fired in the admin-ajax.php processor. This will be automatically added to the data sent to the server. Alternately, you can omit the action string and place it in the data object of the options object and send the options object as the first parameter of this method.

**options**
*Type: Object*
The options object defines the data sent to the server, as well as the success and error callbacks. It will accept any options that jQuery.ajax() accepts along with a few others it handles itself.

* context: (object) The context in which to call both the success and error callbacks.
* data: (object) The data sent to the server. If options is sent as the first parameter of the call, the action must be included here.
* error: (function) The callback triggered for responses sent with wp_send_json_error()
* success: (function) The callback triggered for responses sent with wp_send_json_success()
* type: (string) The type of request to make (e.g. POST, GET ). Default: POST
* url: (string) The URL that the ajax request is sent to. Default: admin-ajax.php

**Return**
*Type: jQuery.promise*
The promise object allows you to attach additional callbacks to the request. All callbacks will be called with the correct context if context was sent as an option.


### Example
```javascript
wp.ajax.send('sajari_score', {
    data: {
        nonce: $(wpNonce).val(),
        post_id: $('#post_ID').val()
    },
    success: callbackSuccess,
    error:   callbackError
});
```

*sajari_score* is a WordPress action. Inside that action `wp_send_json_success();` helper function is used to invoke a success callback:
```php
add_action('wp_ajax_sajari_score', array($this, 'ajaxSajariScore'));
function ajaxSajariScore() {
    $nonce  = isset($_REQUEST["nonce"]) ? $_REQUEST["nonce"] : "";
    $postId = intval($_REQUEST['post_id']);

    // do some stuff in PHP

    $toReply = [
        'body'  => (!empty($duplicateBody)) ? $duplicateBody : 0
    ];

     wp_send_json_success($toReply);
}
```


## wp.template
wp.template is used to create Underscore.js style template functions that, when executed, generates parametrized HTML for rendering. It is located in the wp scope/namespace.

**File Location**: /wp-includes/js/wp-util.js

**ID**
*Type: String*
A string that corresponds to a DOM element with an id prefixed with "tmpl-". For example, "attachment" maps to "tmpl-attachment".

**Return**
*Type: Function*
A function that lazily-compiles the template requested.



### Template syntax
The WordPress-specific interpolation syntax is inspired by Mustache templating syntax:

* Interpolate (unescaped): {{{ }}}
* Interpolate (escaped): {{ }}
* Evaluate: <# #>



### Example
```javascript
var panelContent = wp.template('migration-content');

$panel.find('.panel-content').html( panelContent({
    status: "World",
    content: '<div class="mt-spinner"><div class="mt-spinner-inner"><span></span></div></div>',
    actions: ''
}));
```

Template HTML will look like:
```html
<!-- Status template -->
<script id="tmpl-migration-content" type="text/html">
    <p class="mt-status-message">
        {{data.status}}
    </p>

    <div class="mt-content">
        {{{data.content}}}
    </div>
</script>
```
