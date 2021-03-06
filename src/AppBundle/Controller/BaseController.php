<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController extends Controller
{
    public function searchAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Category')->createQueryBuilder('c');
        $categories = $qb->where('c.enabled = 1 AND c.parent IS NULL')->orderBy('c.name', 'ASC')->getQuery()->setMaxResults(15)->getResult();
        $variables = array(
            'categories' => $categories
        );
        return $this->render('AppBundle:Block:search.html.twig', $variables);
    }

    public function menuAction()
    {
        $session = new Session();
        $sql = "SELECT
          id,parent_id,name,parent_id,alias,image_url,body,meta_keyword,meta_description,position,image_feature
            FROM category
          WHERE category.enabled = 1 AND category.id != 32 AND category.id != 33 AND category.id != 34";
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $categories = $this->buildTree($stmt->fetchAll());
        $sql2 = "SELECT
          id,parent_id,name,parent_id,alias,image_url,body,meta_keyword,meta_description,position,image_feature
            FROM category
          WHERE category.enabled = 1 AND category.parent_id = 32";
        $stmt2 = $em->getConnection()->prepare($sql2);
        $stmt2->execute();
        $trademark = $stmt2->fetchAll();
        $card = $session->get('card');
        $variables = array(
            'categories' => $categories,
            'trademark' => $trademark,
            'card' => count($card)
        );
        return $this->render('AppBundle:Block:menu.html.twig', $variables);
    }

    public function sliderAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Slider')->createQueryBuilder('s');
        $sliders = $qb->where('s.enabled = 1')->orderBy('s.position', 'ASC')->getQuery()->setMaxResults(5)->getResult();
        $variables = array(
            'sliders' => $sliders
        );
        return $this->render('AppBundle:Block:slider.html.twig', $variables);
    }

    public function newsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Article')->createQueryBuilder('a');
        $articles = $qb->where('a.enabled = 1')->orderBy('a.updatedAt', 'DESC')->getQuery()->setMaxResults(5)->getResult();
        $bb = $em->getRepository('AppBundle:SaleOff')->createQueryBuilder('s');
        $saleoff = $bb->where('s.enabled = 1')->orderBy('s.id', 'DESC')->getQuery()->setMaxResults(1)->getSingleResult();
        $variables = array
        (
            'news' => $articles,
            'saleoff' => $saleoff
        );
        return $this->render('AppBundle:Block:news.html.twig', $variables);
    }

    public function buildTree(array $elements, $parentId = null, $parent_id_field = 'parent_id')
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element[$parent_id_field] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                $element['children'] = empty($children) ? [] : $children;

                $branch[] = $element;
            }
        }
        return $branch;
    }

    public static function setMetaData()
    {
        $data['title'] = 'Mỹ phẩm đẹp rạng ngời';
        return $data;
    }

    public function bannerAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Adv')->createQueryBuilder('ad');
        $banner = $qb->where('ad.enabled = 1')->orderBy('ad.position', 'DESC')->getQuery()->setMaxResults(2)->getResult();
        $variables = array
        (
            'banner' => $banner
        );
        return $this->render('AppBundle:Block:banner.html.twig', $variables);
    }
    public function footerAction()
    {
        $variables = [];
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository('AppBundle:Config')->createQueryBuilder('ad');
        $footer = $qb->getQuery()->setMaxResults(2)->getResult();
        if($footer){
            $variables = array
            (
                'contact' => $footer[0],
                'facebook'=>$footer[1]
            );
        }
        return $this->render('AppBundle:Block:footer.html.twig', $variables);
    }
}
