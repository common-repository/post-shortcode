=== Plugin Name ===
Contributors: sachin8600
Donate link: 
Tags: posts, post, shortcode, widget, custom, taxonomy, pages, page, css, layout, recent, thumbnail, themes, pagination
Requires at least: 3.8
Tested up to: 4.8.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is used for display post using widget as well as shortcode.


== Description ==

This plugin is used for display posts in widget as well as shortcode.

Display post shortcode using shortcode generator

Display post widget with selection tools ( like grid view or listing view )

Customize plugin output using functions.php

Display post as well as custome post type

Display post with perticuler Taxonomy, Term, Category, Tag

Display post with selection like: Title, Image, Category, Tag, Cutome Field, Excerpt, Read More, Pagination

Easy to change plugin css from backend plugin page.

Change thubnail size, page number, taxonomy query relation

Generate shortcode using plugin page

Add page parameters like post_parent__in, post_parent__not_in, post__in, post__not_in, post_name__in


*   "Contributors" sachin8600

*   "Tags" posts, post, shortcode, widget, custom, taxonomy, pages, page, css, layout, recent, thumbnail, themes

*   "Requires at least" 3.8

*   "Tested up to" 4.8.2



== Installation ==

This section describes how to install the plugin and get it working.


1. Upload `post-shortcode` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php do_shortcode('[pcs]'); ?>` in your templates

== Frequently Asked Questions ==

= How to use shortcode =

You can use shortcode in two way 

1. In .php file use : <?php do_shortcode('[pcs]'); ?> code or use : [pcs] use in backend editor. 
   In backend menu : 'Post Shorcode' here is generator of shortcode as well as customization

2. Use ps widget in widget area to get output of shortcode


**********   Parameter of shortcode [pcs]  *********

= posttype =
posttype=post //default posttype
check https://codex.wordpress.org/Class_Reference/WP_Query in that page find post_type

= orderby =
orderby=ID //default orderby
check https://codex.wordpress.org/Class_Reference/WP_Query in that page find orderby

= order =
order=ASC //default order
check https://codex.wordpress.org/Class_Reference/WP_Query in that page find order


= postcount =
postcount= 3//default postcount
check https://codex.wordpress.org/Class_Reference/WP_Query in that page find posts_per_page


= template =
template=ws //default effects
other effect is iws, gws, igws, and core

= showfield =
showfield=title,thumbnail,excerpt //default showfield
other are: date,author,cc,content,readme,category,tag, pagination

= excerptl =
excerptl=55 //default excerpt length

= readmoretitle =
readmoretitle='Read more' //Read more readmoretitle


= customfield =
customfield= //default customfield is empty

= tsize =
tsize=thumbnail //default thumbnail  is thumbnail

= paged =
paged=1 //default paged ( page number ) is 1

= taxrel =
taxrel= //default taxrel is OR

= post_parent__in =
post_parent__in= //default is empty

= post_parent__not_in =
post_parent__not_in= //default is empty

= post__in =
post__in= //default is empty

= post__not_in =
post__not_in= //default is empty

= post_name__in =
post_name__in= //default is empty

= pagedvar =
pagedvar= //default is paged, check uniqid().


= categories =
categories=post_tag$dhfghdf,post_tag$test,product_type$simple //default is empty.
taxonomy_slug$term_slug


For shortcode use shortcode generator : Dashboard > Posts > Post Shortcode
== Screenshots ==

1. screenshot-1.png show the backend widget layout.
2. screenshot-2.png show the front end display.
3. screenshot-3.png show backend shortcode generator and customization.

== Changelog ==

= 2.0.9 =
Adding link of creating addon

= 2.0.8 =
Adding addon flexibility and multilanguage support

= 2.0.7 =
Adding pagination parameter in showfield, add core grid theme. (Note : if you change css from backend then please reset css for updating css. )

= 2.0.6 =
Adding page parameters like post_parent__in, post_parent__not_in, post__in, post__not_in, post_name__in

= 2.0.5 =
Adding facilty like: thumbnail size selection, page selection, select taxonomy relation
Solved excerpt default 55 words show 

= 2.0.4 =
Improve backend and add css edit option.

= 2.0.3 =
Improve layout and css.

= 2.0.2 =
Solving bug about menu page and excerpt.

= 2.0.1 =
Solving bug about category and excerpt.

= 2.0.0 =
* A change of whole plugin .
* Another change.

= 1.0 =
* A change since the previous version.
* Change add weidget and shortcode of post type and category.


== Upgrade Notice ==

= 2.0.9 =
Adding link of creating addon

= 2.0.8 =
Adding addon flexibility and multilanguage support

= 2.0.7 =
Adding pagination parameter in showfield, add core grid theme. (Note : if you change css from backend then please reset css for updating css. )

= 2.0.6 =
Adding page parameter like post_parent__in, post_parent__not_in, post__in, post__not_in, post_name__in

= 2.0.5 =
Adding facilty like: thumbnail size selection, page selection, select taxonomy relation
Solved excerpt default 55 words show 

= 2.0.4 =
Improve backend and add css edit option.

= 2.0.3 =
Improve layout and css.

= 2.0.2 =
Solving bug about menu page and excerpt.

= 2.0.1 =
Solving bug about category and excerpt.

= 2.0.0 =
This change of whole plugin its like new plugin with same name.