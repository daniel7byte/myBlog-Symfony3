<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexOldAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entryRepo = $em->getRepository('BlogBundle:Entries');
        $entries = $entryRepo->findAll();
        foreach ($entries as $entry) {
          echo $entry->getTitle() . '<br>';
          echo $entry->getCategory()->getName() . '<br>';
          $tags = $entry->getEntryTag();
          foreach ($tags as $tag) {
            echo $tag->getTag()->getName() . ', ';
          }
          echo '<hr>';
        }
        die();
        return $this->render('BlogBundle:Default:index.html.twig');
    }

    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }
}
