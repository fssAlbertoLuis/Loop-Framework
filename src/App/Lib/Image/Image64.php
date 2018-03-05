<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Lib\Image;

class Image64Exception extends \Exception {}

/**
 * Create image from base64 for json data
 * Class Image64
 * @package LoopFM\Lib\Image
 */
class Image64 extends Image
{
    private $image,
            $type;

    /**
     * Image64 constructor.
     * @param $base64img
     */
    public function __construct(array $base64img)
    {
        $this->createImage($base64img['base64']);
        parent::__construct([
            'name' => $base64img['name'],
            'tmp_name' => null,
            'error' => null,
            'size' => null,
            'type' => $this->type
        ]);

        //sets the tmp_name and proper error code when getting the image type from parent class
        $this->tmpUpload();
    }

    public function __destruct()
    {
        /*if (file_exists($this->getTmpFile())) {
            echo 'destroying object';
            die();
            unlink($this->getTmpFile());
        }*/
        //check destructor problem, to delete possibly garbage images
    }

    /**
     * Generate private var from base64decode image
     * @param $base64
     * @throws Image64Exception
     */
    private function createImage($base64)
    {
        $imagesize = getimagesizefromstring($this->decode($base64));
        if ($imagesize) {
            $this->image = imagecreatefromstring($this->decode($base64));
            $this->type = $imagesize['mime'];
        } else {
            throw new Image64Exception('Imagem inválida');
        }
    }

    /**
     * Convert the image to binary
     * @return bool|string
     */
    private function decode($base64)
    {
        $separate = explode(',', $base64);
        return base64_decode($separate[1]);
    }

    public function tmpUpload()
    {
        $img = null;
        $filename = $this->getName();
        switch ($this->getType()) {
            case 'png':
                $img = imagepng($this->image, 'src/tmp/'.$filename);
                break;
            default:
                $img = imagejpeg($this->image, 'src/tmp/'.$filename);
                break;
        }
        if ($img) {

            $this->setTmpFile(__PATH.'/src/tmp/'.$filename);
            $this->setError(4);
            $this->setSize(filesize($this->getTmpFile()));
        }

    }
}