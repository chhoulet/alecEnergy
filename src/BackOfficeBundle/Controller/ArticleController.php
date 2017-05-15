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

			/*$nextAction = $form->get('saveAndAdd')->isClicked()
		        ? 'back_office_photo_upload', array('idArticle'=>$article->getId())
		        : 'back_office_homepage';*/

		    if($form->get('saveAndAdd')->isClicked())
		    {
		    	return $this->redirectToRoute('back_office_photo_upload', array('idArticle'=>$article->getId()));
		    }
		    else
		    {
		    	return $this->redirectToRoute('back_office_homepage');
		    }
			
		}

		return $this->render('BackOfficeBundle:Article:create.html.twig', 
			array('form'=>$form->createView(),
				  'origin'=>$origin));
	}


	public function listAction()
	{
		$em=$this->getDoctrine()->getManager();
		$articles=$em->getRepository('FrontOfficeBundle:Article')->findAll();

		return $this->render('BackOfficeBundle:Article:articles.html.twig',
			array('articles'=>$articles));
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


	public function deleteAction(Request $request, $idArticle)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();

		if($idArticle)
		{
			$listArticles=$em->getRepository('FrontOfficeBundle:Article')->findAll();
			$listIdArticles=[];
			foreach($listArticles as $article)
			{
				$id=$article->getId();
				$listIdArticles[]=$id;
			}

			if(in_array($idArticle, $listIdArticles))
			{
				$articleDeleted=$em->getRepository('FrontOfficeBundle:Article')->find($idArticle);
				$em->remove($articleDeleted);
				$em->flush();

				$session->getFlashBag()->add('succes', $articleDeleted->getTitle(). ' est définitivement supprimé !');
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


	public function updateAction(Request $request, $idArticle)
	{
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();

		if($idArticle)
		{
			$listArticles=$em->getRepository('FrontOfficeBundle:Article')->findAll();
			$listIdArticles=[];
			foreach($listArticles as $article)
			{
				$id=$article->getId();
				$listIdArticles[]=$id;
			}

			if(in_array($idArticle, $listIdArticles))
			{
				$articleUpdated=$em->getRepository('FrontOfficeBundle:Article')->find($idArticle);
				$dateStamp=$articleUpdated->getDateCreated();
				$dateExpi=$articleUpdated->getDateDeleted();

				if($dateStamp !='')
				{
					// Transformer le timestamp en date:
					$timestamp = $dateStamp;
					$datetimeFormat = 'd-M-Y';

					$date = new \DateTime();					
					$date->setTimestamp($timestamp);
					$date->format($datetimeFormat);
					$articleUpdated->setDateCreated($date);				
				}

				if($dateExpi !='')
				{
					// Transformer le timestamp en date:
					$timestamp = $dateExpi;
					$datetimeFormat = 'd-M-Y';

					$dateT = new \DateTime();
					
					$dateT->setTimestamp($timestamp);
					$dateT->format($datetimeFormat);
					$articleUpdated->setDateDeleted($dateT);					
				}

				$form=$this->createForm(ArticleType::class, $articleUpdated);
				$form->handleRequest($request);

				if($form->isSubmitted()&&$form->isValid())
				{
					$dateCreated=$articleUpdated->getDateCreated();
					$dateDeleted=$articleUpdated->getDateDeleted();

					$dateCreated=$dateCreated->getTimeStamp();
					$dateDeleted=$dateDeleted->getTimeStamp();

					$articleUpdated->setDateCreated($dateCreated);
					$articleUpdated->setDateDeleted($dateDeleted);
					$em->flush();
					$session->getFlashBag()->add('succes', $articleUpdated->getTitle(). ' a bien été mis à jour !');

					if($form->get('saveAndAdd')->isClicked())
					{
						return $this->redirectToRoute('back_office_photo_upload', array('idArticle'=>$articleUpdated->getId()));
					}
					else
					{
						return $this->redirectToRoute('back_office_article_list');						
					}
				}
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

		return $this->render('BackOfficeBundle:Article:update.html.twig',
			array('form'=>$form->createView(),
			 	  'article'=>$articleUpdated));
	}

	public function editAction($idArticle)
	{
		$em=$this->getDoctrine()->getManager();
		
		if($idArticle)
		{
			$listArticles=$em->getRepository('FrontOfficeBundle:Article')->findAll();
			$listIdArticles=[];
			foreach($listArticles as $article)
			{
				$id=$article->getId();
				$listIdArticles[]=$id;
			}

			if(in_array($idArticle, $listIdArticles))
			{
				$articleEdited=$em->getRepository('FrontOfficeBundle:Article')->find($idArticle);	
				$dateCreated=$articleEdited->getDateCreated();
				$dateDeleted=$articleEdited->getDateDeleted();

				$dateCreatedToSet=new \DateTime();
				$dateDeletedToSet=new \DateTime();
				$dateFormat='d-M-Y';
				$dateCreatedToSet->format($dateFormat);
				$dateDeletedToSet->format($dateFormat);

				$dateCreatedToSet->setTimeStamp($dateCreated);
				$dateDeletedToSet->setTimeStamp($dateDeleted);

				$articleEdited->setDateCreated($dateCreatedToSet);
				$articleEdited->setDateDeleted($dateDeletedToSet);

				return $this->render('BackOfficeBundle:Article:edit.html.twig', 
					array('articleEdited'=>$articleEdited));
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