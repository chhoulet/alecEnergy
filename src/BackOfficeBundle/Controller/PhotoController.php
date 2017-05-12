<?php

namespace BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontOfficeBundle\Entity\Photo;
use FrontOfficeBundle\Form\PhotoType;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
	public function uploadAction(Request $request, $idArticle)
	{
		$em=$this->getDoctrine()->getManager();

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
				$article=$em->getRepository('FrontOfficeBundle:Article')->find($idArticle);
				$photo=new Photo();
				$form=$this->createForm(PhotoType::class, $photo);
				$form->handleRequest($request);

				if($form->isSubmitted() && $form->isValid())
				{
					$file=$photo->getFilename();
					$filename=md5(uniqid()).'.'.$file->guessExtension();
					$file->move($this->getParameter('photos_directory'), $filename);
					$photo->setFilename($filename);
					$photo->setArticle($article);

					$em->persist($photo);
					$em->flush();

					if($form->get('saveAndAdd')->isClicked())
				    {
				    	return $this->redirectToRoute('back_office_photo_upload', array('idArticle'=>$article->getId()));
				    }
				    else
				    {
				    	return $this->redirectToRoute('back_office_homepage');
				    }					
				}

				return $this->render("BackOfficeBundle:Photo:upload.html.twig",
					array('form'=>$form->createView(),
						  'article'=>$article));
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