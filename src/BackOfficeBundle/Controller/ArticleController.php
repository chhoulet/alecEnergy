<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Article;
use FrontOfficeBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
	public function createAction(Request $request, $origin)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$article=new Article();
		$form=$this->createForm(ArticleType::class, $article);

		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid())
		{
			$datePubli=$article->getDateCreated();			

			if(!$datePubli)
			{
				$dateCreated=new \DateTime();
				$date=$dateCreated->getTimeStamp();
				$article->setDateCreated($date);				
			}

			$article->setOrigin($origin);

			$em->persist($article);
			$em->flush();

			$session->getFlashBag()->add('success', $article->getTitle() . ' est bien créé et ajouté en base !');
			return $this->redirectToRoute('back_office_homepage');
		}

		return $this->render('BackOfficeBundle:Article:create.html.twig', 
			array('form'=>$form->createView(),
				  'origin'=>$origin));
	}
}