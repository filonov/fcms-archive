<?php

/**
 * Categoryes DataMapper Model
 *
 * Use this basic model as a menu for creating new models.
 * It is not recommended that you include this file with your application,
 * especially if you use a Categoryes library (as the classes may collide).
 *
 * To use:
 * 1) Copy this file to the lowercase name of your new model.
 * 2) Find-and-replace (case-sensitive) 'Categoryes' with 'Your_model'
 * 3) Find-and-replace (case-sensitive) 'menu' with 'your_model'
 * 4) Find-and-replace (case-sensitive) 'menus' with 'your_models'
 * 5) Edit the file as desired.
 *
 * @license		MIT License
 * @category	Models
 * @author		Phil DeJarnett
 * @link		http://www.overzealous.com
 */
class Category extends DataMapper
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
    var $table = 'categoryes';

    /*  */
    // You can override the database connections with this option
    // var $db_params = 'db_config_name';
    // --------------------------------------------------------------------
    // Relationships
    //   Configure your relationships below
    // --------------------------------------------------------------------
    // Insert related models that Categoryes can have just one of.
    var $has_one = array();
    // Insert related models that Categoryes can have more than one of.
    var $has_many = array();

    /* Relationship Examples
     * For normal relationships, simply add the model name to the array:
     *   $has_one = array('user'); // Categoryes has one User
     *
     * For complex relationships, such as having a Creator and Editor for
     * Categoryes, use this form:
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
            'rules' => array('required', 'trim', 'max_length' => 255),
            'label' => 'Название'
        ),
        'alias' => array(
            'rules' => array('unique', 'trim', 'required', 'max_length' => 255),
            'label' => 'Алиас'
        ),
        'template' => array(
            'rules' => array('trim', 'max_length' => 255),
            'label' => 'Шаблон'
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

    /**
     * Для функции block_content - генерирует путь
     * @param type $id
     * @param type $root
     * #REFACTOR - Зачем id, и так в объекте.
     */
    function get_tree_full_path($id, $root = CATEGORYES_CONTENT)
    {
        $this->select_root($root);
        $this->get_by_id($id);
        $path = array();
        while (!$this->is_root())
        {
            $path[] = $this->alias;
            $this->get_parent();
        }
        $path = array_reverse($path);
        return implode('/', $path);
    }

    function get_alias_path($root = CATEGORYES_CONTENT)
    {
        $id = $this->id;
        $this->select_root($root);
        $this->get_by_id($id);
        $path = array();
        while (!$this->is_root())
        {
            $path[] = $this->alias;
            $this->get_parent();
        }
        $path = array_reverse($path);
        $this->get_by_id($id);
        return implode('/', $path);
    }

    /**
     * Возвращает все подкатегории текущей категории.
     */
    function get_all_childs()
    {
        $old_id = $this->id;
        $ids = array();
        $parent = $this;

        $this->get_first_child();
        $ids[] = $this->id;
        while ($this->is_child($parent))
        {
            if ($this->get_next_sibling()->exists())
                $ids[] = $this->id;
        }
        $res = $this->where_in('id', $ids)->order_by('lft')->get_iterated();
        $this->id = $old_id;
        return $res;
    }
    
   
}

/* End of file menu_orm.php */
/* Location: ./application/models/menu_orm.php */
