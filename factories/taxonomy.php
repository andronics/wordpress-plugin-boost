<?

// Prevent file from being loaded directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class BoostTaxonomy extends BoostBase {

	public const NAME = "Boost Taxonomy";

	public $capabilities = array();
	
	public $description;
	
	public $hierarchical = true;
	
	public $menu_name;

	public $meta_box_cb;
	
	public $post_types;

	public $public = true;
	public $public_queryable = true;
	
	public $query_var;
	
	public $rest_base;
	public $rest_controller_class;

	public $rewrite = true;

	public $rewrite_ep_mask;
	public $rewrite_hierarchical;
	public $rewrite_slug;
	public $rewrite_with_front;

	public $show_admin_column = true;
	public $show_in_menu = true;
	public $show_in_nav_menu = true;
	public $show_in_quick_edit = true;
	public $show_in_rest = true;
	public $show_tagcloud = true;
	public $show_ui = true;

	public $sort;

	public $taxonomy_plural;
	public $taxonomy_singular;
	public $taxonomy_type;

	public $update_count_callback;

	public function __construct() {

		parent::__construct();
		
		$this->register_taxonomy_type();
		
	}

	public function init() {}

	private function get_labels() {

		self::validate_taxonomy_names();

		return array(
            "name"                       => __( ucfirst($this->taxonomy_plural) ),
			"singular_name"         	 => __( ucfirst($this->taxonomy_singular) ),
			"menu_name"                  => __( empty($this->menu_name) ? $this->menu_name : ucfirst($this->post_plural) ),
			"all_items"                  => __( "All " . ucfirst($this->taxonomy_plural) ),
			"edit_item"                  => __( "Edit " . ucfirst($this->taxonomy_singular) ),
			"view_item"                  => __( "View " . ucfirst($this->taxonomy_singular) ),
			"update_item"                => __( "Update " . ucfirst($this->taxonomy_singular) ),
			"add_new_item"               => __( "Add New " . ucfirst($this->taxonomy_singular) ),
			"new_item_name"              => __( "New " . ucfirst($this->taxonomy_singular) ),
			"parent_item"                => __( "Parent " . ucfirst($this->taxonomy_plural) ),
			"parent_item_colon"          => __( "Parent " . ucfirst($this->taxonomy_singular) . ":" ),
			"search_items"               => __( "Search " . ucfirst($this->taxonomy_plural) ),
            "popular_items"              => __( "Popular " . ucfirst($this->taxonomy_plural) ),
            "separate_items_with_commas" => __( "Separate " . $this->taxonomy_plural . " with commas" ),
            "add_or_remove_items"        => __( "Add or remove " . $this->taxonomy_plural ),
			"choose_from_most_used"      => __( "Choose from most used " . $this->taxonomy_plural ),
        );

	}

	private function get_rewrite() {

		if (false !== $this->rewrite) {
			return $this->rewrite;
		}
		
		return array(
			'ep_mask'					=> $this->rewrite_ep_mask,
			'hierarchical'				=> $this->rewrite_hierarchical,
			'slug'						=> $this->rewrite_slug,
			'with_front'				=> $this->rewrite_with_front,
		);

	}

	private function get_taxonomy_type_args() {

		// https://codex.wordpress.org/Function_Reference/register_taxonomy#Parameters

		return array(
			"capabilities"				 => $this->capabilities,
			"description"				 => $this->description,
			"hierarchical"				 => $this->hierarchial,
			"labels" 					 => $this->get_labels(),
			"meta_box_cb"				 => $this->meta_box_cb,
			"public" 					 => $this->public,
			"public_queryable"			 => $this->public_queryable,
			"query_var"					 => $this->query_var,
			"rest_base"    				 => $this->rest_base,
			"rest_controller_class"		 => $this->rest_controller_class,
			"rewrite"    				 => $this->get_rewrite(),
			"show_admin_column"			 => $this->show_admin_column,
			'show_in_menu'               => $this->show_in_menu,
			'show_in_nav_menu'           => $this->show_in_nav_menu,
			'show_in_quick_edit'         => $this->show_in_quick_edit,
			'show_in_rest'               => $this->show_in_rest,
			'show_tagcloud'              => $this->show_tagcloud,
			'show_ui'                    => $this->show_ui,
			'sort'						 => $this->sort,
			'update_count_callback'      => $this->update_count_callback,
        );

	}

	public function register_taxonomy_type() {

		$this->validate_taxonomy_type();

		register_taxonomy(
			$this->taxonomy_type,
			$this->post_types,
			apply_filters(
				"boost_taxonomy_" . $this->taxonomy_type . '_posts', $this->get_taxonomy_type_args()
			)
		);


	}

	private function validate_taxonomy_type() {
		
		if ( ! isset($this->taxonomy_type) ) {
			throw new Exception("taxonomy_type value not set");
		}
	
	}
	
	private function validate_taxonomy_names() {
		
		if ( ! isset($this->taxonomy_plural) || ! isset($this->taxonomy_singular) ) {
			throw new Exception("taxonomy_plural / taxonomy_singular value not set not set");
		}
	
	}

}

?>