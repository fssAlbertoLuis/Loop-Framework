<?php
use LoopFM\Core\Controller;
use LoopFM\Lib\Http\Header;
use LoopFM\Lib\Session\Session;
use LoopFM\Lib\Token;

class indexController extends Controller
{
    public function index()
    {
        $this->template->view('home');
    }
}
