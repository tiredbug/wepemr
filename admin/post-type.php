<?php
if(!class_exists('Wpemr_Patient'))
{
	/**
	 * A PostType class that provides additional meta fields
	 */
	class Wpemr_Patient
	{
		const POST_TYPE	= "wpemr_patient";
		private $_meta	= array(
			'full_name',
			'sex',
			'birthdate',
			'address',
			'phone_number',
			'occupation',
			'marriage',
		);
		
    	/**
    	 * The Constructor
    	 */
    	public function __construct()
    	{
    		// register actions
    		add_action('init', array(&$this, 'init'));
    		add_action('admin_init', array(&$this, 'admin_init'));
    	} // END public function __construct()

    	/**
    	 * hook into WP's init action hook
    	 */
    	public function init()
    	{
    		// Initialize Post Type
    		$this->create_post_type();
    		add_action('save_post', array(&$this, 'save_post'));
    	} // END public function init()

    	/**
    	 * Create the post type
    	 */
    	public function create_post_type()
    	{
    		register_post_type(self::POST_TYPE,
    			array(
    				'labels' => array(
    					'name'               => _x( 'Patients', 'post type general name', 'wpemr' ),
					    'singular_name'      => _x( 'Patient', 'post type singular name', 'wpemr' ),
					    'menu_name'          => _x( 'Patients', 'admin menu', 'wpemr' ),
					    'name_admin_bar'     => _x( 'Patient', 'add new on admin bar', 'wpemr' ),
					    'add_new'            => _x( 'Add New', 'wpemr', 'wpemr' ),
					    'add_new_item'       => __( 'Add New Patient', 'wpemr' ),
					    'new_item'           => __( 'New Patient', 'wpemr' ),
					    'edit_item'          => __( 'Edit Patient', 'wpemr' ),
					    'view_item'          => __( 'View Patient', 'wpemr' ),
					    'all_items'          => __( 'All Patients', 'wpemr' ),
					    'search_items'       => __( 'Search Patients', 'wpemr' ),
					    'parent_item_colon'  => __( 'Parent Patients:', 'wpemr' ),
					    'not_found'          => __( 'No patients found.', 'wpemr' ),
					    'not_found_in_trash' => __( 'No patients found in Trash.', 'wpemr' )
    				),
		        	'description'        => __( 'Description.', 'wpemr' ),
				    'public'             => true,
				    'publicly_queryable' => true,
				    'show_ui'            => true,
				    'show_in_menu'       => true,
				    'query_var'          => true,
				    'rewrite'            => array( 'slug' => 'wpemr' ),
        			'capability_type'    => array ('wpemr', 'wpemrs'),       
        			'map_meta_cap' 	     => true,
				    'has_archive'        => true,
				    'hierarchical'       => false,
				    'menu_position'      => 5,
				    'menu_icon' 	     => 'dashicons-clipboard',
    				'supports' => array(''),
    			)
    		);
    	}
	
    	/**
    	 * Save the metaboxes for this custom post type
    	 */
    	public function save_post($post_id)
    	{
            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }
            
    		if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    		{
    			foreach($this->_meta as $field_name)
    			{
    				// Update the post's meta field
    				update_post_meta($post_id, $field_name, $_POST[$field_name]);
    			}
    		}
    		else
    		{
    			return;
    		} // if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    	} // END public function save_post($post_id)

    	/**
    	 * hook into WP's admin_init action hook
    	 */
    	public function admin_init()
    	{			
    		// Add metaboxes
    		add_action('add_meta_boxes', array(&$this, 'add_meta_boxes'));
    	} // END public function admin_init()
			
    	/**
    	 * hook into WP's add_meta_boxes action hook
    	 */
    	public function add_meta_boxes()
    	{
    		// Add this metabox to every selected post
    		add_meta_box( 
    			sprintf('wpemr-metabox'),
    			sprintf('%s Information', ucwords(str_replace("_", " ", self::POST_TYPE))),
    			array(&$this, 'add_inner_meta_boxes'),
    			self::POST_TYPE, 'advanced', 'high'
    	    );					
    	} // END public function add_meta_boxes()

		/**
		 * called off of the add meta box
		 */		
		public function add_inner_meta_boxes($post)
		{		
			// Render the job order metabox
			include(sprintf("%s/../views/metabox.php", dirname(__FILE__)));			
		} // END public function add_inner_meta_boxes($post)

	} // END class Wpemr_Patient
} // END if(!class_exists('Wpemr_Patient'))
