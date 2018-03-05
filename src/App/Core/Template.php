<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Core;

use \Exception;
use LoopFM\Lib\Cache\JSCache;
use LoopFM\Lib\Validate;
use LoopFM\Lib\Cache;
use LoopFM\Lib\Minifier;

/**
 * Template
 *
 * @package    Loop Sandbox Framework
 * @author     Luis Alberto <albertoluis0108@gmail.com>
 */
Class Template
{
    /*
    * @ registry
    *
    */
    private $registry;

    /*
    * @ stored config file
    */
    private $configs;

    /*
    * @ a vector of variables which will be acessible through a view file
    *
    */
    private $vars = array();

    /*
    * @ String with css files
    *
    */
    private $css_files;

    /*
    * @ string with js files
    *
    */
    private $js_files;

    /**
    *
    * @constructor
    *
    * @access public
    *
    * @return void
    *
    */
    function __construct($registry)
    {
        $this->registry = $registry;
        $this->configs = $this->registry->configs;
    }


    /**
    *
    * @ set view vars
    *
    * @param string $index
    *
    * @param mixed $value
    *
    * @return void
    *
    */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
    *
    * Loads multiple css into template header
    *
    * @access private
    *
    * @param string $css - comma separated css files
    *
    * @return void
    *
    */
    public function loadCss($css)
    {
        $this->css_files = '';
        $css_files = explode(',', $css);

        if ($css) {
            $css_directory = $this->configs['directories']['css'];
            foreach ($css_files as $css_path) {
                $css_name = trim($css_path, '/');
                $css = $css_directory . '/' . $css_name;
                if (!is_dir(__PATH.$css_directory)) {
                    die('Css folder not found in: '.$css_directory);
                }
                if (!is_readable(__PATH.$css)) {
                    die("Css file unavailable ". $css);
                }
                $this->css_files .=
                    '<link href="'.$css.'" rel="stylesheet" type="text/css" '.
                    ' media="screen">'."\n";
            }
        }
    }

    /**
    *
    * Loads javascript files into template header
    *
    * @access private
    *
    * @param string $js - A string separated by commas for each javascript file
    *
    * @param bool $cache - if true, will cache all js files into one minified file, but will
    *                      ignore caching command if file already exists, to prevent excessive cpu drain
    *
    * @param  string $cached_filename - if set, will use the choosen name to create te minified file, if null,
    *                                   the function will auto generate cached js filename based on all js files
    *
    * @return void
    *
    */
    public function loadJavascript($js_string,$cache=false,$cached_filename=null) {
        $this->js_files = '';
        $long_string = $js_string;
        $js_files = explode(',', $js_string);
        $js_directory = $this->configs['directories']['js'];
        $temp_name = '';
        if ($cache) {
            $filelist = [];
            foreach($js_files as $js_path) {

                $js_folder = __PATH . $js_directory;

                if (!is_dir($js_folder)) {
                    die("Javascript folder not found in: ". $js_directory);
                }
                $js_file_name = trim($js_path, '/');
                $js = $js_directory . '/' . $js_file_name;
                if (!is_readable(__PATH.$js)) {
                    die("Js file unavailable in: ". $js);
                }
                $js_exp = explode('/', $js_path);
                $file_name = end($js_exp);
                $temp_name .= $file_name;
                array_push($filelist,__PATH.$js);
            }
            if (!$cached_filename) {
                $cached_filename = $temp_name;
            }
            $filename = md5(trim($cached_filename)).".js";
            $to = __PATH.$js_directory."/".$filename;
            JSCache::shrinkFiles($filelist,$to);
            $cached_filepath = $js_directory."/".$filename;
            $this->js_files = '<script src="'.$cached_filepath.'"></script>';
        } else {
            foreach($js_files as $js_path) {
                $js_folder = __PATH . $js_directory;

                if (!is_dir($js_folder)) {
                    die("Javascript folder not found in: ". $js_directory);
                }
                $js_file_name = trim($js_path, '/');
                $js = $js_directory . '/' . $js_file_name;
                if (!is_readable(__PATH.$js)) {
                    die("Js file unavailable in: ". $js);
                }
                $this->js_files .= '<script src="'.$js.'"></script>'."\n";
            }
        }
    }

    /**
    *
    * @ Renders view
    *
    * @access public
    *
    * @param string $name - Name of view file, if no extension is informed .php extension is applied
    *
    * @param bool $template - If true, renders the layout automatically, if false, only loads the view file.
    *
    * @return void
    *
    */
    public function view($name, $template=true)
    {
        $name_exp = explode('.', $name);
        $view_file_extension = end($name_exp);
        if ($view_file_extension != 'php' && $view_file_extension !== 'html') {
            $name = $name . '.php';
        }

        if ($template) {
            $image_directory = $this->configs['directories']['img'];
            $logo_name = trim($this->configs['layout']['logo'], '/');
            $logo = $image_directory.'/'.$logo_name;

            $title = $this->configs['general']['title'];

            $css_files = $this->css_files ? $this->css_files : '';

            $js_files = $this->js_files ? $this->js_files : '';

            foreach ($this->vars as $key => $value) {
                $$key = $value;
            }

            $theme_directory = $this->configs['directories']['themes'];
            $theme_name = trim($this->configs['layout']['theme_name'], '/');
            $theme = $theme_directory . '/' . $theme_name;

            $template_directory = $this->configs['directories']['templates'];
            $template_name = trim($this->configs['layout']['template_name'], '/');
            $template = $template_directory . '/' . $template_name;

            if (!is_dir(__PATH.$template)) {
                die("Template: '{$template}' folder not found. Check if dirname is correctly typed on config or 
                     dir name has the same name in config file.");
            }

            $header_file = __PATH.$template.'/header.php';
            if (!is_readable($header_file)) {
                die("'header.php' not found in selected template.");
            }
            include $header_file;
        }

        $content_path = __PATH . $this->configs['directories']['content'];
        if (!is_dir($content_path)) {
            die("Content folder not found. Check your config file.");
        }
        $content_name = trim($name, '/');
        $content = $content_path. '/' . $content_name;
        if(!is_readable($content)) {
            die("View file '{$name}' not found in view folder.");
        }

        include $content;

        if ($template) {
            $footer_file = __PATH.$template.'/footer.php';
            if (!is_readable($footer_file)) {
                die("'footer.php' file not found in selected template.");
            }
            include $footer_file;
        }
    }
}
