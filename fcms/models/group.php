<?php

/**
 * Groups_orm DataMapper Model
 *
 * Use this basic model as a group for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Groups_orm library (as the classes may collide).
 *
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Groups_orm' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'group' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'groups' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Group extends DataMapper
{

    // Uncomment and edit these two if the class has a model name that
    //   doesn't convert properly using the inflector_helper.
    //var $model = 'group';
    var $table = 'groups';
    // You can override the database connections with this option
    // var $db_params = 'db_config_name';
    // --------------------------------------------------------------------
    // Relationships
    //   Configure your relationships below
    // --------------------------------------------------------------------
    // Insert related models that Groups_orm can have just one of.
    // Insert related models that Groups_orm can have more than one of.
    var $has_one = array();
    // Insert related models that Catalog_categoryes_orm can have more than one of.
    var $has_many = array('textbook');

    /* Relationship Examples
     * For normal relationships, simply add the model name to the array:
     *   $has_one = array('user'); // Groups_orm has one User
     *
     * For complex relationships, such as having a Creator and Editor for
     * Groups_orm, use this form:
     *   $has_one = array(
     *   	'creator' => array(
     *   		'class' => 'user',
     *   		'other_field' => 'created_group'
     *   	)
     *   );
     *
     * Don't forget to add 'created_group' to User, with class set to
     * 'group', and the other_field set to 'creator'!
     *
     */
    // --------------------------------------------------------------------
    // Validation
    //   Add validation requirements, such as 'required', for your fields.
    // --------------------------------------------------------------------

    var $validation = array(
        'order' => array(
            'rules' => array('required'),
            'label' => '??????????????'
        ),
        'type' => array(
            'rules' => array('required'),
            'label' => '?????? ????????????'
        ),
        'language' => array(
            'rules' => array('required'),
            'label' => '????????'
        ),
        'level' => array(
            'rules' => array('required'),
            'label' => '??????????????'
        ),
        'special' => array(
            'rules' => array('required'),
            'label' => '?????? ??????????????????'
        ),
        'program' => array(
            'rules' => array('required'),
            'label' => '?????????????????? ??????????'
        ),
//        'textbook_old' => array(
//            'rules' => array('required'),
//            'label' => '???????????????? ?????????????? ??????????????'
//        ),
        'days' => array(
            'rules' => array('required', 'max_length' => 100),
            'label' => '?????? ??????????????'
        ),
        'days' => array(
            'rules' => array('required', 'max_length' => 50),
            'label' => '?????????? ??????????????'
        ),
        'date' => array(
            'rules' => array('required'),
            'label' => '???????? ???????????? ??????????????'
        ),
        'status' => array(
            'rules' => array('required'),
            'label' => '???????????? ????????????'
        ),
        'teacher' => array(
            'rules' => array('required'),
            'label' => '?????????????????????????? ????????????'
        ),
        'format' => array(
            'rules' => array('required'),
            'label' => '???????????? ????????????????'
        ),
        'duration' => array(
            'rules' => array('required'),
            'label' => '??????????????????????????????????'
        ),
        'price' => array(
            'rules' => array('required'),
            'label' => '??????????????????'
        ),
        'test' => array(
            'rules' => array('required'),
            'label' => '????????'
        ),
    );
    // --------------------------------------------------------------------
    // Default Ordering
    //   Uncomment this to always sort by 'name', then by
    //   id descending (unless overridden)
    // --------------------------------------------------------------------
    var $default_order_by = array('order', 'date');

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
      function get_open_groups()
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

/* End of file group.php */
/* Location: ./application/models/group.php */
