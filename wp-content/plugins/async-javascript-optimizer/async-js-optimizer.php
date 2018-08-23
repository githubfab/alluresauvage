<?php # -*- coding: utf-8 -*-
declare( encoding = 'UTF-8' );
/**
 * Plugin Name: Async Javascript Optimizer
 * Description: Adds <code>async</code> to all javascript links for fast loading of webpage.
 * Version:     1.0
 * Text Domain: async-js-optimizer
 * Required:    4.0
 * Author:      Taimoor Zaffar
 * Author URI:  http://www.AskTaimoor.com
 * License:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 *
 * Async Javascript Optimizer, Copyright (C) 2014 Taimoor Zaffar
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */



! defined( 'ABSPATH' ) and exit;

if ( ! function_exists( 'add_js_async' ) )
{
	function add_js_async( $url )
	{
			if(stripos($url,'.js')===FALSE)
				return $url;
			else
				return $url."' async='async";
	}
	add_filter( 'clean_url', 'add_js_async', 11, 1 );
}