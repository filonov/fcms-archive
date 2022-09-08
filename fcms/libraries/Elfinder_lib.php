<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(0);

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elfinder/elFinderConnector.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elfinder/elFinder.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elfinder/elFinderVolumeDriver.class.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'elfinder/elFinderVolumeLocalFileSystem.class.php';


class Elfinder_lib
{

    public function __construct($opts)
    {
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }

}

