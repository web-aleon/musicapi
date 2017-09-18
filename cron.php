<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */
require_once __DIR__."/../../../wp-admin/includes/taxonomy.php";
require_once __DIR__.'/../../../wp-load.php';
require_once 'api/djbay.php';
require_once 'api/posts-generator.php';
require_once 'functions.php';

if ( get_option( 'wbh_is_autoupload' ) ){

	if ( get_option( 'wbh_startdate' ) ){
		$start_date = strtotime(get_option( 'wbh_startdate' ));
	} else {
		$start_date = time();
	}

	$end_date = time();

	for($i = $start_date; $i < $end_date; $i += (60*60*24)){
	    $date = date("d.m.Y", $i);
	    $tracksArray = wbh_getDjbayTracks($date);
	    wbh_postGenerator( $tracksArray );

	}

}
