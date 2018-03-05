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

/**
 * Controller
 *
 *
 * @package    Loop Sandbox Framework
 * @author     Luis Alberto <albertoluis0108@gmail.com>
 */
abstract class Controller
{
    protected $registry,
              $configs,
              $template,
              $router;

    /**
    *
    * @ construtor
    *
    * @param Class Registry
    *
    *
    * @return void
    *
    */
    public function __construct($registry)
    {
        $this->registry = $registry;
        $this->configs = $this->registry->configs;
        $this->template = $this->registry->template;
        $this->router = $this->registry->router;

        $this->template->title = $this->configs['general']['title'];
    }

    abstract function index();
}
?>
