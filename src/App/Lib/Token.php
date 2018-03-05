<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LoopFM\Lib;

use \Firebase\JWT\JWT;
use LoopFM\Lib\Http\Header;

class Token
{
    private $secret_key,
            $server_name;

    /**
     * Token constructor.
     * @param $configs - array of configurations
     */
    function __construct($configs)
    {
        $this->secret_key = $configs['preferences']['token'];
        $this->server_name = $configs['general']['url'];
    }

    /**
     * Get data from token in Authorization header
     * @return mixed
     */
    public function get()
    {
        $token = Header::request('Authorization');
        if ($token) {
            try {        
                $token = $this->extract($token);
                $response = $this->resolve($this->secret_key, $token);
                return $response->data;
            } catch (\Exception $e) {
                Header::err400();
                echo $e->getMessage();
                die();
            }
        } else {
            return false;
        }
    }

    /**
     * Generate web token from provided info and utilizes passcode from configs to
     * encrypt data
     * @param $info
     * @return string
     */
    public function generate($info)
    {
        $tokenId    = base64_encode(random_bytes(32));
        $issuedAt   = time();
        $notBefore  = $issuedAt + 0;
        $expire     = $notBefore + 3600;
        $serverName = $this->server_name;
        $data = [
            'iat'  => $issuedAt,
            'jti'  => $tokenId,
            'iss'  => $serverName,       
            'nbf'  => $notBefore,
            'exp'  => $expire,           
            'data' => $info
        ];                      
        $jwt = JWT::encode($data, $this->secret_key);
        return $jwt;
    }

    /**
     * decode token based on the token itself and the key
     * @param $key
     * @param $token
     * @return object
     */
    public function resolve($key, $token)
    {
        return JWT::decode($token, $key, array('HS256'));
    }

    /**
     * Extract token from Bearer header
     * @param $bearer
     * @return mixed
     */
    public function extract($bearer)
    {
        return str_replace('Bearer ','', $bearer);
    }
}