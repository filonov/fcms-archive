<?php

/**
 * Catalog_images_orm DataMapper Model
 *
 * Use this basic model as a catalog_images for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Catalog_images_orm library (as the classes may collide).
 *
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Catalog_images_orm' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'catalog_images' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'catalog_imagess' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Catalog_images_orm extends DataMapper
{

    // Uncomment and edit these two if the class has a model name that
    //   doesn't convert properly using the inflector_helper.
    //var $model = 'Catalog_images_orm';
    var $table = 'catalog_images';
    // You can override the database connections with this option
    // var $db_params = 'db_config_name';
    // --------------------------------------------------------------------
    // Relationships
    //   Configure your relationships below
    // --------------------------------------------------------------------
    // Insert related models that Catalog_images_orm can have just one of.
    var $has_one = array();
    // Insert related models that Catalog_images_orm can have more than one of.
    var $has_many = array();

    /* Relationship Examples
     * For normal relationships, simply add the model name to the array:
     *   $has_one = array('user'); // Catalog_images_orm has one User
     *
     * For complex relationships, such as having a Creator and Editor for
     * Catalog_images_orm, use this form:
     *   $has_one = array(
     *   	'creator' => array(
     *   		'class' => 'user',
     *   		'other_field' => 'created_catalog_images'
     *   	)
     *   );
     *
     * Don't forget to add 'created_catalog_images' to User, with class set to
     * 'catalog_images', and the other_field set to 'creator'!
     *
     */
    // --------------------------------------------------------------------
    // Validation
    //   Add validation requirements, such as 'required', for your fields.
    // --------------------------------------------------------------------

    var $validation = array(
        'SKU' => array(
            'rules' => array('required', 'max_length' => 255),
            'label' => 'SKU'
        ),
        'title' => array(
            'rules' => array('required', 'max_length' => 1024),
            'label' => 'Заголовок'
        ),
        'alias' => array(
            'rules' => array('required', 'max_length' => 1024),
            'label' => 'Алиас'
        ),
        'category' => array(
            'rules' => array('numeric'),
            'label' => 'Категория'
        ),
        'price' => array(
            'rules' => array('numeric'),
            'label' => 'Цена'
        ),
        'meta_title' => array(
            'rules' => array('max_length' => 1024),
            'label' => 'META-TITLE'
        ),
        'meta_keywords' => array(
            'rules' => array('max_length' => 1024),
            'label' => 'META-KEYWORDS'
        ),
        'meta_description' => array(
            'rules' => array('max_length' => 1024),
            'label' => 'META-DESCRIPTION'
        ),
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
      function get_open_catalog_imagess()
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

/* End of file catalog_images.php */
/* Location: ./application/models/catalog_images.php */
