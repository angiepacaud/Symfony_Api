<?php

namespace Api\SymfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ApiSymfBundle/Default/index.html.twig');
    }
}
