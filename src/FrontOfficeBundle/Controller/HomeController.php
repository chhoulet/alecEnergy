<?php

namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homepageAction()
    {
        return $this->render('FrontOfficeBundle:Home:homepage.html.twig');
    }
}
