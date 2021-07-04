<?php
/**
 * Demo content configuration
 *
 * @package finedine
 */


$config = array(
	'static_page'    => 'home',
	'posts_page'     => 'blog',
	'menu_locations' => array(
		'menu-1' => 'main-menu',
	),
);

Finedine_Demo_Import::init( apply_filters( 'Finedine_Demo_Import_filter', $config ) );
