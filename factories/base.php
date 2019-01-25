<?

// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

abstract class BoostBase {

	protected const NAME = "Boost Base";
	protected const VERSION = "0.0.1";

	private static $instance = array();

	static function debug($x) {
		// convert things into out for jQuery Modal Windows
		// crate custom jquery plugins to view
		// echo sprintf(
		// 	'
		// 	=========================\n
		// 	%1s - %2s\n
		// 	=========================\n
		// 	%3s\n
		// 	',
		// 	self::NAME,
		// 	self::VERSION,
		// 	$x
		// );
	}

	public function __construct() {

		$this->init();

	}

	public static function instance() {

		$class = get_called_class();

		if ( !isset(self::$instance[$class]) ) {
			self::$instance[$class] = new $class;
		}

		return self::$instance[$class];

	}
	
	protected function init() {}

}

?>