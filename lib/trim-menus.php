<?php

add_filter('nav_menu_css_class', 'strip_menu_css', 100, 1);
add_filter('nav_menu_item_id', 'strip_menu_css', 100, 1);

function strip_menu_css($content) {
	return false;
}

