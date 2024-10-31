<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   NS_Comment_Validator
 * @author    Nilambar Sharma<nilambar@outlook.com>
 * @license   GPL-2.0+
 * @link      http://nilambar.net
 * @copyright 2013 Nilambar Sharma
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

//Define uninstall functionality here

delete_option('cvns_options');
