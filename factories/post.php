<?

// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class BoostPost extends BoostBase {

	public const NAME = "Boost Post";

	// public $capabilities = array(
	// 	'create_posts' => 'do_not_show',
	// );

	public $capabilities = array();


	public $capability_type = "post";

	public $delete_with_user;

	public $description;

	public $exclude_from_search;
	
	public $has_archive = false;

	public $hierarchical = false;

	public $map_meta_cap;

	public $menu_icon = "dashicons-groups";
	public $menu_name;
	public $menu_position = 2;

	public $permalink_epmask;

	public $post_plural;
	public $post_singular;
	public $post_type;

	public $public = true;
	public $publicly_queryable = false;

	public $query_var = true;

	public $register_meta_box_cb;

	public $rest_base;
	public $rest_controller_class;

	public $rewrite;
	
	public $rewrite_ep_mask;
	public $rewrite_feeds;
	public $rewrite_pages;
	public $rewrite_slug;
	public $rewrite_with_front;

	public $show_in_admin_bar;
	public $show_in_menu;
    public $show_in_nav_menus;
    public $show_in_rest;
	public $show_tag_cloud;
	public $show_ui;

	public $support = array();
	public $unsupport = array();

	public $taxonomies = array();

	public function __construct() {

		parent::__construct();

		$this->register_hooks();
		$this->register_post_type();
		
	}

	public function init() {}

	public function filter_updated_messages($messages) {

		$messages[$this->post_type] = $this->get_messages();

	}

	private function get_labels() {

		self::validate_post_names();

		return array(
			"name"                       => __( ucfirst($this->post_plural) ),
			"singular_name"			     => __( ucfirst($this->post_singular) ),
			"add_new"                    => __( "Add " . ucfirst($this->post_singular) ),
			"add_new_item"               => __( "Add " . ucfirst($this->post_singular) ),
			"edit_item"                  => __( "Edit " . ucfirst($this->post_singular) ),
			"new_item"                   => __( "New " . ucfirst($this->post_singular) ),
			"view_item"                  => __( "View " . ucfirst($this->post_singular) ),
			"search_items"               => __( "Search " . ucfirst($this->post_plural) ),
			"not_found"                  => __( "No " . $this->post_singular . " found" ),
			"not_found_in_trash"         => __( "No " . $this->post_singular . " found in Trash" ),
			"all_items"                  => __( "All ". ucfirst($this->post_plural) ),
			"archives"                   => __( ucfirst($this->post_singular) . ' Archives' ),
			"attributes"                 => __( ucfirst($this->post_singular) . ' Attributes' ),
			"menu_name"                  => __( isset($this->menu_name) ? $this->menu_name : ucfirst($this->post_plural) ),
		);

	}

	private function get_messages() {

		$this->validate_post_names();

		global $post;

		return array(
			0  							=> __( "" ), 
			1							=> __( sprintf(ucfirst($this->post_singular)." updated. <a href='%s'>View " . ucfirst($this->post_singular) . "</a>", esc_url( get_permalink( $post->ID ) ) ) ),
			2							=> __( "Custom field updated." ),
			3							=> __( "Custom field deleted." ),
			4							=> __( ucfirst($this->post_singular) . " updated." ),
			5							=> __( isset( $_GET['revision'] ) ? sprintf( ucfirst($this->post_singular) . " restored to revision from %s", wp_post_revision_title( (int) $_GET['revision'], false ) ) : false ),
			6							=> __( sprintf(ucfirst($this->post_singular) . " published. <a href='%s'>View " . ucfirst($this->post_singular) . "</a>", esc_url( get_permalink( $post->ID ) ) ) ),
			7							=> __( ucfirst($this->post_singular) . " saved." ),
			8							=> __( sprintf(ucfirst($this->post_singular) . " submitted. <a target='_blank' href='%s'>Preview " . ucfirst($this->post_singular) . "</a>", esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) ) ),
			9							=> __( sprintf(ucfirst($this->post_singular) . " scheduled for: <strong>%1$s</strong>. <a target='_blank' href='%2$s'>Preview " . ucfirst($this->post_singular) . "</a>",  strtotime( $post->post_date ), esc_url( get_permalink( $post->ID ) ) ) ),
			10							=> __( sprintf(ucfirst($this->post_singular) . " draft updated. <a target='_blank' href='%s'>Preview " . ucfirst($this->post_singular) . "</a>", esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) ) ),
		);

	}

	private function get_post_type_args() {

		// https://codex.wordpress.org/Function_Reference/register_post_type#Parameters

		return array(
			"can_export"                => $this->can_export,
			"capabilities"              => $this->capabilities,
			"capability_type"           => $this->capability_type,
			"delete_with_user"          => $this->delete_with_user,
			"description"           	=> $this->description,
			"exclude_from_search"      	=> $this->exclude_from_search,
			"labels"					=> $this->get_labels(),
			"has_archive"				=> $this->has_archive,
			"hierarchical"              => $this->hierarchical,
			"map_meta_cap"              => $this->map_meta_cap,
			"menu_icon"                 => $this->menu_icon,
			"menu_position"             => $this->menu_position,
			"permalink_epmask"          => $this->permalink_epmask,
			"public"                    => $this->public,
			"publicly_queryable"        => $this->publicaly_queryable,
			"query_var"					=> $this->query_var,
			"register_meta_box_cb"      => $this->register_meta_box_cb,
			"rest_base"    				=> $this->rest_base,
			"rest_controller_class"		=> $this->rest_controller_class,
			"rewrite"					=> $this->get_rewrite(),
			"show_in_admin_bar"         => $this->show_in_admin_bar,
			"show_in_menu"              => $this->show_in_menu,
			"show_in_nav_menus"         => $this->show_in_nav_menu,
			"show_in_rest"              => $this->show_in_rest,
			"show_tag_cloud"			=> $this->show_in_tag_cloud,
			"show_ui"                   => $this->show_ui,
			"supports"                  => $this->get_supports(),
			"taxonomies"				=> $this->get_taxonomies()
		);

	}

	private function get_rewrite() {

		if (false !== $this->rewrite) {
			return $this->rewrite;
		}
		
		return array(
			// 'ep_mask'				=> $this->rewrite_ep_mask,
			// 'feeds'					=> $this->rewrite_feeds,
			// 'pages'					=> $this->rewrite_pages,
			'slug'					=> $this->rewrite_slug,
			'with_front'			=> $this->rewrite_with_front,
		);

	}

	private function get_supports() {

		$defaults = array( "title", "thumbnail","custom-fields");

		return array_diff(
            array_merge(
                $defaults, $this->support
            ),
            $this->unsupport
        );

	}

	private function get_taxonomies() {


		return $this->taxonomies;
	
	}

	public function register_hooks() {
		
		add_filter( 'post_updated_messages', array($this, 'filter_updated_messages') );

	}

	public function register_post_type() {

		$this->validate_post_type();

		register_post_type(
			$this->post_type,
			apply_filters(
				"boost_post_" . $this->post_plural . '_posts', $this->get_post_type_args()
			)
		);

	}

	private function validate_post_type() {
		
		if ( ! isset($this->post_type) ) {
			throw new Exception("post_type value not set");
		}
	
	}
	
	private function validate_post_names() {
		
		if ( ! isset($this->post_plural) || ! isset($this->post_singular) ) {
			throw new Exception("plural/singular value not set not set");
		}
	
	}

}

?>