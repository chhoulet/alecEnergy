<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homepageAction()
    {
        return $this->render('BackOfficeBundle:Home:homepage.html.twig');
    }
}
