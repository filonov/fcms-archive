<?php

/**
 * Teachers_orm DataMapper Model
 *
 * Use this basic model as a teacher for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Teachers_orm library (as the classes may collide).
 *
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Teachers_orm' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'teacher' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'teachers' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Teacher extends DataMapper
{

    // Uncomment and edit these two if the class has a model name that
    //   doesn't convert properly using the inflector_helper.
    // var $model = 'teacher';
    var $table = 'teachers';
    // You can override the database connections with this option
    // var $db_params = 'db_config_name';
    // --------------------------------------------------------------------
    // Relationships
    //   Configure your relationships below
    // --------------------------------------------------------------------
    // Insert related models that Teachers_orm can have just one of.
    var $has_one = array();
    // Insert related models that Teachers_orm can have more than one of.
    var $has_many = array();

    /* Relationship Examples
     * For normal relationships, simply add the model name to the array:
     *   $has_one = array('user'); // Teachers_orm has one User
     *
     * For complex relationships, such as having a Creator and Editor for
     * Teachers_orm, use this form:
     *   $has_one = array(
     *   	'creator' => array(
     *   		'class' => 'user',
     *   		'other_field' => 'created_level'
     *   	)
     *   );
     *
     * Don't forget to add 'created_level' to User, with class set to
     * 'teacher', and the other_field set to 'creator'!
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
        'title_short' => array(
            'rules' => array('required', 'max_length' => 255),
            'label' => 'Краткое название'
        ),
        'order' => array(
            'rules' => array('required'),
            'label' => 'Порядок'
        ),
        'photo' => array(
            'rules' => array('max_length' => 1024),
            'label' => 'Фотография'
        ),
    );

    // --------------------------------------------------------------------
    // Default Ordering
    //   Uncomment this to always sort by 'name', then by
    //   id descending (unless overridden)
    // --------------------------------------------------------------------
    var $default_order_by = array('order');
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
      function get_open_levels()
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

/* End of file teacher.php */
/* Location: ./application/models/teacher.php */