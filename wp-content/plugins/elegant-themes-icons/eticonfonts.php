<?php
/*
Plugin Name: Elegant Themes Icons for WordPress
Plugin URI: #
Description: Easily use the ET icon Font in WordPress.
Version:  1.3
Author: Mayur Somani, threeroutes media
Author URI: http://www.agentwp.com
Author Email: contact@agentwp.com
Credits:
    The ET Font icons were created by Elegant Themes
     http://www.elegantthemes.com
License:

  Copyright (C) 2013  Nazmul Hasan Rupok

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class ETIconFonts {
    public function __construct() {
        add_action( 'init', array( &$this, 'init' ) );
    }

    public function init() {
        add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
        add_shortcode( 'icon', array( $this, 'setup_shortcode' ) );
        add_filter( 'widget_text', 'do_shortcode' );
    }

    public function register_plugin_styles() {
        global $wp_styles;
       
	    wp_enqueue_style( 'eticonfont-styles', plugins_url( 'assets/css/etfonts-style.css', __FILE__  ) );
    }

    public function setup_shortcode( $params ) {
        extract( shortcode_atts( array(
                    'name'  => 'icon-wrench'
                ), $params ) );
        $icon = '<span class="'.$name.'">&nbsp;</span>';

        return $icon;
    }

}

new ETIconFonts();
