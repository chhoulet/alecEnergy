<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Article;
use FrontOfficeBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
			$dateExpi=$article->getDateDeleted();

			if(!$datePubli)
			{
				$dateCreated=new \DateTime();
				$date=$dateCreated->getTimeStamp();
				$article->setDateCreated($date);				
			}
			else
			{
				$date=$datePubli->getTimeStamp();
				$article->setDateCreated($date);
			}

			if($dateExpi)
			{
				$date=$dateExpi->getTimeStamp();
				$article->setDateDeleted($date);				
			}

			$article->setOrigin($origin);

			$em->persist($article);
			$em->flush();

			$session->getFlashBag()->add('succes', $article->getTitle() . ' est bien créé et ajouté en base !');
			return $this->redirectToRoute('back_office_homepage');
		}

		return $this->render('BackOfficeBundle:Article:create.html.twig', 
			array('form'=>$form->createView(),
				  'origin'=>$origin));
	}

	public function activateAction(Request $request, $idArticle)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();

		if($idArticle)
		{
			$listArticles=$em->getRepository('FrontOfficeBundle:Article')->findByActive(2);
			$listIdArticles=[];
			foreach($listArticles as $article)
			{
				$id=$article->getId();
				$listIdArticles[]=$id;
			}

			if(in_array($idArticle, $listIdArticles))
			{
				$articleActivated=$em->getRepository('FrontOfficeBundle:Article')->find($idArticle);
				$articleActivated->setActive(1);
				$em->flush();

				$session->getFlashBag()->add('succes', $articleActivated->getTitle(). ' est activé et disponible dans l\'espace client !');
				return $this->redirectToRoute('back_office_homepage');
			}
			else
			{
				throw new NotFoundHttpException("Cet article n\'existe pas !");
			}
		}
		else
		{
			throw new NotFoundHttpException("Cet article n\'existe pas !");
		}	
	}


	public function desactivateAction(Request $request, $idArticle)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();

		if($idArticle)
		{
			$listArticles=$em->getRepository('FrontOfficeBundle:Article')->findByActive(1);
			$listIdArticles=[];
			foreach($listArticles as $article)
			{
				$id=$article->getId();
				$listIdArticles[]=$id;
			}

			if(in_array($idArticle, $listIdArticles))
			{
				$articledesActivated=$em->getRepository('FrontOfficeBundle:Article')->find($idArticle);
				$articledesActivated->setActive(2);
				$em->flush();

				$session->getFlashBag()->add('succes', $articledesActivated->getTitle(). ' est désactivé et retiré de l\'espace client !');
				return $this->redirectToRoute('back_office_homepage');
			}
			else
			{
				throw new NotFoundHttpException("Cet article n\'existe pas !");
			}
		}
		else
		{
			throw new NotFoundHttpException("Cet article n\'existe pas !");
		}	
	}
}