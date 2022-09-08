<?php

/**
 * Mma_osago_np DataMapper Model
 *
 * Use this basic model as a mma_osago_np for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Mma_osago_np library (as the classes may collide).
 *
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Mma_osago_np' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'mma_osago_np' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'mma_osago_np' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Mma_osago_np extends DataMapper
{

    // Uncomment and edit these two if the class has a model name that
    //   doesn't convert properly using the inflector_helper.
    // var $model = 'mma_osago_np';
    var $table = 'mma_osago_np';
    // You can override the database connections with this option
    // var $db_params = 'db_config_name';
    // --------------------------------------------------------------------
    // Relationships
    //   Configure your relationships below
    // --------------------------------------------------------------------
    // Insert related models that Mma_osago_np can have just one of.
    var $has_one = array();
    // Insert related models that Mma_osago_np can have more than one of.
    var $has_many = array();

    /* Relationship Examples
     * For normal relationships, simply add the model name to the array:
     *   $has_one = array('user'); // Mma_osago_np has one User
     *
     * For complex relationships, such as having a Creator and Editor for
     * Mma_osago_np, use this form:
     *   $has_one = array(
     *   	'creator' => array(
     *   		'class' => 'user',
     *   		'other_field' => 'created_template'
     *   	)
     *   );
     *
     * Don't forget to add 'created_template' to User, with class set to
     * 'mma_osago_np', and the other_field set to 'creator'!
     *
     */

    // --------------------------------------------------------------------
    // Validation
    //   Add validation requirements, such as 'required', for your fields.
    // --------------------------------------------------------------------
//	var $validation = array(
//		'example' => array(
//			// example is required, and cannot be more than 120 characters long.
//			'rules' => array('required', 'max_length' => 120),
//			'label' => 'Example'
//		)
//	);
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
    }

    // --------------------------------------------------------------------
    // Post Model Initialisation
    //   Add your own custom initialisation code to the Model
    // The parameter indicates if the current config was loaded from cache or not
    // --------------------------------------------------------------------
    function post_model_init($from_cache = FALSE)
    {
	
    }

    // --------------------------------------------------------------------
    // Custom Methods
    //   Add your own custom methods here to enhance the model.
    // --------------------------------------------------------------------

    /* Example Custom Method
      function get_open_templates()
      {
      return $this->where('status <>', 'closed')->get();
      }
     */

    // --------------------------------------------------------------------
    // Custom Validation Rules
    //   Add custom validation rules for this model here.
    // --------------------------------------------------------------------

    /* Example Rule
      function _convert_written_numbers($field, $parameter)
      {
      $nums = array('one' => 1, 'two' => 2, 'three' => 3);
      if(in_array($this->{$field}, $nums))
      {
      $this->{$field} = $nums[$this->{$field}];
      }
      }
     */
}

/* End of file mma_osago_np.php */
/* Location: ./application/models/mma_osago_np.php */
