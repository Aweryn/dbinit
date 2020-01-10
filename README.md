# [DB Init]

## How to use this plugin

DB Init is a plugin that includes various snippets for wordpress development used in Don & Branco.
To enable only specific snippets and add your custom ones, remove the comments from the initial dbinit.php file

## Custom post types

You can register custom post types with a shorthand command.
Any arguments added in \$args will be appeneded to the function

```
$name = '';
$singular = '';
$args = array();

DB\register_cpt($name, $singular, $args);
```

## Snippets

Enable various snippets for your project

**Hide pages** </br>
Hides unnecessary pages from all other admins except email domains ending in specified one.

**Hide dashboard widgets** </br>
Hides all other dashboard widgets except "Recent activity".

**Disable emojis** </br>
Doesn't need explanation really. Disables emojis all over wp.

**Hide wp update** </br>
Hide WP update message from dashboard.

## Sage 8/9

No snippets yet

## Woocommerce

No snippets yet
