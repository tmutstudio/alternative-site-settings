<img src="images/icon-128x128.png" align="left" style="margin-left: 10px; margin-bottom: 10px;">

# How to connect table plugin to classic TinyMCE editor


<br>

-------------
[Back to Start Recipes page](../recipes_and_tips.md)
<br><br><br>
First, let's create a directory for the TinyMCE plugins, like this:<br>
<b>`admin/js/tinymce-plugins/`</b>  
<br>
Then we add the folder directly with the plugin itself (in our case, this is a table):<br>
<b>`admin/js/tinymce-plugins/table/plugin.min.js`</b>

Now it's time to add functions and filters to connect the plugin and add the button itself. I prefer to do this in the `includes/admin-plugin-functions.php` file, but you can do it in any other place convenient for you.
And here is the code itself:

```
function add_the_table_button( $buttons ) {
    array_push( $buttons, 'separator', 'table' );
    return $buttons;
}
add_filter( 'mce_buttons', 'add_the_table_button' );

function add_the_table_plugin( $plugins ) {
      $plugins['table'] = ALTSITESET_URL . '/admin/js/tinymce-plugins/table/plugin.min.js';
      return $plugins;
}
add_filter( 'mce_external_plugins', 'add_the_table_plugin' );
```
<br><br>

In this way you can connect any missing plugin. Well, and the plugin files themselves you will find on the TinyMCE Github page:<br>
[tinymce-dist/plugins/](https://github.com/tinymce/tinymce-dist/tree/master/plugins)
