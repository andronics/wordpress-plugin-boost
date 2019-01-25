<?

// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class BoostWidget extends WP_Widget {

	protected $config;

	function __construct() {

		parent::__construct( $this->config['id'], $this->config['name'], $this->config['options'] );
	
	}

	public function form($instance) {

	}

	static function init() {

		register_widget( get_called_class() );

	}

	public function update($new_instance, $old_instance) {

	}

	public function widget($args, $instance) {


	}

}

?>