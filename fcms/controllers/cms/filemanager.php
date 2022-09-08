<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Filemanager extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_root();
    }

    function connector()
    {
        $opts = array(
            //'debug' => true, 
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => $this->config->item('path_for_uploads'),
                    'URL' => $this->config->item('url_for_uploads'),
                    'attributes' => array(
                        array(// hide tumbnails
                            'pattern' => '/.tmb/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => false
                        )
                    )
                )
            )
        );
        $this->load->library('Elfinder_lib', $opts);
    }

    function index()
    {
        $data = template_base_tags() + 
                array(
                    'connector_url' => base_url('cms/filemanager/connector')
                );
        $this->parser->parse($this->config->item('tplpath') . '/cms/filemanager', $data);
    }

    /**
     *  Для вызова как менеджера файлов из TinyMCE
     */
    function tinymce()
    {
        $data = template_base_tags();
        $this->parser->parse($this->config->item('tplpath') . '/cms/filemanager_tinymce', $data);
    }

    /**
     * PHP Backend for elFinder
     * @param type $id
     */
    function connector_catalog($id)
    {
        $opts = array(
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => $this->config->item('path_for_uploads') . 'catalog/' . $id,
                    'URL' => $this->config->item('url_for_uploads') . 'catalog/' . $id,
                    'tmbSize' => 48,
                    'tmbPath' => '.tmb',
                    'uploadAllow' => array('image'),
                    'attributes' => array(
                        array(// hide tumbnails
                            'pattern' => '/.tmb/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => false
                        ),
                        array(// hide tumbnails
                            'pattern' => '/tmb/',
                            'read' => false,
                            'write' => false,
                            'hidden' => true,
                            'locked' => false
                        )
                    )
                )
            )
        );
        $this->load->library('Elfinder_lib', $opts);
    }

    function catalog($id)
    {
        $data = template_base_tags() +
                array('connector_url' => base_url('cms/filemanager/connector_catalog/'.$id));
        $this->parser->parse($this->config->item('tplpath') . '/cms/filemanager', $data);
    }

}
