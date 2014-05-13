<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till the nav menu
 *
 * @package WordPress
 * @subpackage kibble
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body>

<?php include(get_template_directory() . '/lib/menu-top.php');?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2 class="page-header text-center"><strong><a href="<?php echo site_url();?>/"><?php bloginfo('name');?></a></strong></h2>
</div>

<div class="container top">

<div class="row">

