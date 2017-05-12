<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homepageAction()
    {
    	$em=$this->getDoctrine()->getManager();

		$articles=$em->getRepository('FrontOfficeBundle:Article')->findByActive(1);

        return $this->render('BackOfficeBundle:Home:homepage.html.twig',
        	array('articles'=>$articles));
    }
}
