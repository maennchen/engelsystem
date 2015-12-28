<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        return [];
    }
}
