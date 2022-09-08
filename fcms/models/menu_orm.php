<?php

/**
 * Menu DataMapper Model
 *
 * Use this basic model as a menu for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Menu library (as the classes may collide).
 *
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Menu' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'menu' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'menus' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Menu_orm extends DataMapper
{
    var $nestedsets = array(
        'name' => 'title',
        'left' => 'lft',
        'right' => 'rgt',
        'root' => 'root',
        'follow' => FALSE
        );

    // Uncomment and edit these two if the class has a model name that
    //   doesn't convert properly using the inflector_helper.
    //var $model = 'categoryes_orm';
    var $table = 'menu';
    
  /*  */
    // You can override the database connections with this option
    // var $db_params = 'db_config_name';
    // --------------------------------------------------------------------
    // Relationships
    //   Configure your relationships below
    // --------------------------------------------------------------------
    // Insert related models that Menu can have just one of.
    var $has_one = array();
    // Insert related models that Menu can have more than one of.
    var $has_many = array();

    /* Relationship Examples
     * For normal relationships, simply add the model name to the array:
     *   $has_one = array('user'); // Menu has one User
     *
     * For complex relationships, such as having a Creator and Editor for
     * Menu, use this form:
     *   $has_one = array(
     *   	'creator' => array(
     *   		'class' => 'user',
     *   		'other_field' => 'created_menu'
     *   	)
     *   );
     *
     * Don't forget to add 'created_menu' to User, with class set to
     * 'menu', and the other_field set to 'creator'!
     *
     */
    // --------------------------------------------------------------------
    // Validation
    //   Add validation requirements, such as 'required', for your fields.
    // --------------------------------------------------------------------

    var $validation = array(
        'title' => array(
            'rules' => array('required', 'max_length' => 255),
            'label' => 'Название'
        ),
        'link' => array(
            'rules' => array('max_length' => 1024),
            'label' => 'Ссылка'
        )
    );

    // --------------------------------------------------------------------
    // Default Ordering
    //   Uncomment this to always sort by 'name', then by
    //   id descending (unless overridden)
    // --------------------------------------------------------------------
    // var $default_order_by = array('name', 'id' => 'desc');
    // --------------------------------------------------------------------

    /**
     * Constructor: calls parent constructor
     */
    function __construct($id = NULL)
    {    
        parent::__construct($id);   
        $this->tree_config(); 
    }

    // --------------------------------------------------------------------
    // Post Model Initialisation
    //   Add your own custom initialisation code to the Model
    // The parameter indicates if the current config was loaded from cache or not
    // --------------------------------------------------------------------
    function post_model_init($from_cache = FALSE)
    {
        
    }
}

/* End of file menu_orm.php */
/* Location: ./application/models/menu_orm.php */
