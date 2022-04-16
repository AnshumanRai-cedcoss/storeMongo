<?php

use Phalcon\Mvc\Controller;

/**
 * Index class
 * The first class to be loaded
 */
class IndexController extends Controller
{
    public function indexAction()
    {
    }

    public function errorAction()
    {
    }

    public function extraAction()
    {
        die;
    }
}
