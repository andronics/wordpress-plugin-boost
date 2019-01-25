<?php
/*
	Plugin Name: Boost
	Plugin URI: https://github.com/andronics/boost
	Description: Extendable framework for boosting WordPress productivity with support for ACF & Divi
	Author: andronics
	Author URI: https://github.com/andronics/
	Version: 0.1
	License: GNU General Public License v2.0
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
	Text Domain: boost_framework
	Domain Path: /languages

 */

// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

define('BOOST_DOMAIN', 'BOOST');
define('BOOST_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BOOST_PLUGIN_URL', plugin_dir_url(__FILE__));

define('BOOST_TEMPLATE_DIR', plugin_dir_url(__FILE__) . 'templates/');

// load autoloader
require BOOST_PLUGIN_DIR . '/vendor/autoload.php';

// load traits
require BOOST_PLUGIN_DIR . '/traits/logging.php';
require BOOST_PLUGIN_DIR . '/traits/overloading.php';

// load factories
require BOOST_PLUGIN_DIR . '/factories/base.php';

require BOOST_PLUGIN_DIR . '/factories/acf.php';
require BOOST_PLUGIN_DIR . '/factories/api.php';
require BOOST_PLUGIN_DIR . '/factories/core.php';
require BOOST_PLUGIN_DIR . '/factories/oauth.php';
require BOOST_PLUGIN_DIR . '/factories/post.php';
require BOOST_PLUGIN_DIR . '/factories/service.php';
require BOOST_PLUGIN_DIR . '/factories/taxonomy.php';
require BOOST_PLUGIN_DIR . '/factories/widget.php';

add_action('init', 'boost_init');
function boost_init() {

	global $boost;

	// load core
	$boost = BoostCore::instance();

	$pug = new Pug(
		array(
			'pretty' => true,
			'cache' => '.cache/'
		)
	);

}

?>