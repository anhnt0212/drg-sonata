<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;

class BaseController extends Controller
{
    public function searchAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Category')->createQueryBuilder('c');
        $categories = $qb->where('c.enabled = 1 AND c.parent = 30')->orderBy('c.name', 'ASC')->getQuery()->setMaxResults(15)->getResult();
        $variables = array(
            'categories' => $categories
        );
        return $this->render('AppBundle:Block:search.html.twig', $variables);
    }
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Category')->createQueryBuilder('c');
        $categories = $qb->where('c.enabled = 1')->orderBy('c.name', 'ASC')->getQuery()->getResult();
        $variables = array(
            'categories' => $categories
        );
        return $this->render('AppBundle:Block:menu.html.twig', $variables);
    }
}
