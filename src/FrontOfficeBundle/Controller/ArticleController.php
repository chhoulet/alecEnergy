<?php
namespace FrontOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
	public function presentationAction($origin)
	{
		$em=$this->getDoctrine()->getManager();

		$listArticles=$em->getRepository('FrontOfficeBundle:Article')->findBy(array('origin'=>$origin, 'active' =>1));

		return $this->render('FrontOfficeBundle:Article:presentation.html.twig',
			array('listArticles'=>$listArticles));
	}
}