<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class RouterException extends \Exception
{
    const CONTROLLER_FILE_NOT_FOUND =
        "No controllers found. Check controller path at config file and verify if your controller file name is correct.".
        "<br>The correct name to a controller file is controller_nameController.<br>".
        "Example: To a controller called 'register' the controller filename would be: 'registerController.php'";
}