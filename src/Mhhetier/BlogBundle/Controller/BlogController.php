<?php

namespace Mhhetier\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mhhetier\BlogBundle\Entity\Article;
use Mhhetier\BlogBundle\Entity\Image;
use Mhhetier\BlogBundle\Entity\Commentaire;
use Mhhetier\BlogBundle\Entity\Categorie;
use Mhhetier\BlogBundle\Form\ArticleType;

class BlogController extends Controller
{
    public function indexAction($page)
    {
        $repository = $this->getDoctrine()
                           ->getManager()
                           ->getRepository("MhhetierBlogBundle:Article");
        //$articles = $repository->findAll();
        /*$articles = $repository->findBy(array(),
                                        array("datecreation" => "desc"),
                                        5,
                                        0
                                        );*/
        $articles = $repository->getArticles();
        
        return $this->render('MhhetierBlogBundle:Blog:index.html.twig', array('articles' => $articles));
    }
    
    public function voirAction($id)
    {
        $repository = $this->getDoctrine()
                           ->getManager()
                           ->getRepository("MhhetierBlogBundle:Article");
      /*  $article1 = $repository->find($id);
        
        $repository2 = $this->getDoctrine()
                            ->getManager()
                            ->getRepository("MhhetierBlogBundle:Commentaire");      
        $commentaires = $repository2->findBy(array('article'=>$article1));*/
        
        $article1 = $repository->getArticleById($id);
          
        return $this->render('MhhetierBlogBundle:Blog:voir.html.twig', array('article1' => $article1));
        
        //return $this->render('MhhetierBlogBundle:Blog:voir.html.twig', array('article1' => $article1, 'commentaires' => $commentaires));     
       // return $this->render('MhhetierBlogBundle:Blog:voir.html.twig', array('article1' => $article1));
    }  
    
    public function ajouterAction()
    {
        $article = new Article;
        $form = $this->createForm(new ArticleType(), $article);
        
        $request = $this->getRequest();
        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);
               
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);

            try {
                $entityManager->flush();
            } catch (Exception $ex) {

            }
        }        
        return $this->render("MhhetierBlogBundle:Blog:ajouter.html.twig",array("form" => $form->createView()));
        
        
        /*
        $formBuilder
           ->add("datecreation", "date")
           ->add("titre", "text")
           ->add("contenu", "text")
           ->add("auteur", "text")
           ->add("publication", "checkbox")
                ;
        $form = $formBuilder->getForm();
        return $this->render("MhhetierBlogBundle:Blog:ajouter.html.twig",array("form" => $form->createView()));
        */       
        
      /*  $article->setTitre("Titre 1")
                ->setContenu("Lorem ipsum bla bla bla")
                ->setAuteur("Hélène");
        
        $article2 = new Article;
        $article2->setTitre("Titre 2")
                ->setContenu("Lorem ipsum bla bla bla 2 ")
                ->setAuteur("Thierry");
        
        $image = new Image;
        $image->setUrl("photo.jpg");
        $image->setAlt("Mon Image");    
        $article->setImage($image);
        
        $commentaire = new commentaire;
        $commentaire->setAuteur("M. Bidule");
        $commentaire->setContenu("mon commentaire, bla bla bla");
        $commentaire->setArticle($article);
        
        $categorie = new categorie;
        $categorie->setNom("Categorie 1");
        $article->addCategory($categorie);
        
        $entityManager = $this->getDoctrine()->getManager(); //création de l'objet entity manager
       
        $entityManager->persist($article); //on démarre une transaction
        $entityManager->persist($article2);
        $entityManager->persist($commentaire);
        $entityManager->persist($categorie);
        
        //$entityManager->clear(); //le flush ne fonctionnerait pas
        //$entityManager->detach($titre); //titre ne serait pas enregistré
        //$entityManager->remove($article); //exécute un delete sur article
        
        $entityManager->flush(); //méthode qui déclenche l'envoi des requêtes
        
        return $this->render('MhhetierBlogBundle:Blog:ajouter.html.twig', array('article' => $article, 'article2' => $article2, 'commentaire' => $commentaire, 'categorie' => $categorie));
       */ 
    }   
    
    
    public function modifierAction($id)
    {        
       $entityManager = $this->getDoctrine()->getManager();
       $article = $entityManager->getRepository("MhhetierBlogBundle:Article")->find($id);
       if (!$article) {
           throw $this->createNotFoundException(
               'Aucun article trouvé pour cet id : '.$id
           );
       }       
        $form = $this->createForm(new ArticleType(), $article);
        
        $request = $this->getRequest();
        if ($request->getMethod() == "POST") {
            $form->handleRequest($request);
               
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);

            try {
                $entityManager->flush();
            } catch (Exception $ex) {

            }
        }        
        return $this->render("MhhetierBlogBundle:Blog:ajouter.html.twig",array("form" => $form->createView()));
           
               
    }   
   
    public function menuGaucheAction()
    {
        $articles = array(
            array("titre"=>"Hello World 1", "contenu"=>"Lorem ipsum dolor 1"),
            array("titre"=>"Hello World 2", "contenu"=>"Lorem ipsum dolor 2"),
            array("titre"=>"Hello World 3", "contenu"=>"Lorem ipsum dolor 3"),
        );
        
        return $this->render('MhhetierBlogBundle:Blog:menuGauche.html.twig', array('articles' => $articles));
    }      
}
