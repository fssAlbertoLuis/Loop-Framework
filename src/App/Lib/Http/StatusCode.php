<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Http;


/**
 * Encapsulates status codes of http requests
 * Class StatusCode
 * @package LoopFM\Lib\Http
 */
class StatusCode
{
    const BAD_REQUEST = "HTTP/1.0 400 Bad Request",
          UNAUTHORIZED = "HTTP/1.1 401 Unauthorized",
          FORBIDDEN = "HTTP/1.0 403 Forbidden",
          NOT_FOUND = "HTTP/1.0 404 Not Found",
          SERVER_ERROR = "HTTP/1.0 500 Internal Server Error";
}