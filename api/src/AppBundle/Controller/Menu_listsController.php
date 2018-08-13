<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Menu_container;
use AppBundle\Entity\Menu_lists;
use AppBundle\Form\Menu_lists_form;

class Menu_listsController extends Controller {

    /**
     * @Rest\View()
     * @Rest\Get("/getmenu")
     */
    public function getMenuAction() {
        $menu_repository = $this->getDoctrine()->getRepository(Menu_container::class);
        $menu_name = $menu_repository->findAll();
        $add = $this->getDoctrine()->getManager();
        return ($menu_name) ? $menu_name: false;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/getlist/{menutitle}/{menuid}/{paginate}/{page}/{limit}")
     */
    public function getListMenuAction($menutitle, $menuid, $paginate = 1, $page = 1, $limit = 5) {

        $Menu = $this->get('doctrine.orm.entity_manager')
                ->getRepository(Menu_lists::class)
                ->createQueryBuilder('v')
                ->where('v.idMenu = ' . $menuid);

        if ($paginate) {
            $Menu_clone = clone($Menu);
            $lists['count'] = (int) $Menu->select('COUNT(v) as list')->getQuery()->getResult()[0]['list'];

            // Check offset to be valid
            $limit = (int) $limit;
            $page = (int) $page;
            $page = ($page > 0 && $page <= ceil($lists['count'] / $limit)) ? $page : 1;
            $offset = ($page * $limit) - $limit;

            $tmp_menu = $Menu_clone->setFirstResult($offset)->setMaxResults($limit)->getQuery()->getResult();

            $lists['p_current'] = $page;
            $lists['p_prev'] = $page - 1 < 0 ? $page : $page - 1;
            $lists['p_next'] = $page + 1 > $lists['count'] ? $page : $page + 1;
        } else {
            $tmp_menu = $Menu->getQuery()->getResult();
        }
        
        $lists['contain'] = [];
        foreach ($tmp_menu as $key => $value) {
            $tmp_val = unserialize($value->getMenuLists());
            $tmp_val['id'] = $value->getId();
            array_push($lists['contain'], $tmp_val);
        }

        return $lists;
    }

     /**
     * @Rest\View()
     * @Rest\Post("/add/{menutitle}/{menuid}")
     */
    public function addMenuListAction(Request $request, $menutitle, $menuid) {
        $post_values = $request->request->all();
        // Validations
        foreach ($post_values as $key => $value) {
            if(!$value)
                return false;
        }
        $post_values = serialize($post_values);

        $menuORM = new Menu_lists();
        $entityManager = $this->getDoctrine()->getManager();

        // setting values
        $menuORM->setIdMenu($menuid);
        $menuORM->setMenuLists($post_values);
        $menuORM->setStatus(1);

        $entityManager->persist($menuORM);
        $entityManager->flush();

        return true;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/updateList/{menuid}/{menulistid}")
     */
    public function updateMenuListAction(Request $request, $menuid, $menulistid) {
        $entityManager = $this->getDoctrine();
        $menuList = $entityManager->getRepository(Menu_lists::class)->find($menulistid);
        if (!$menuList)
            return false;

        $post_values = $request->request->all();
        // Validations
        foreach ($post_values as $key => $value) {
            if(!$value)
                return false;
        }
        $post_values = serialize($post_values);

        // setting values
        $menuList->setIdMenu($menuid);
        $menuList->setMenuLists($post_values);
        $menuList->setStatus(1);

        $entityManager->getManager()->flush();

        return $menuid;
    }

     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Post("/delete/{menuid}/{menulistid}")
     */
    public function removeBoissonAction(Request $request, $menuid, $menulistid) {
        $entityManager = $this->getDoctrine();
        $menuList = $entityManager->getRepository(Menu_lists::class)->find($menulistid);
        if (!$menuList)
            return false;

        $entityManager->getManager()->remove($menuList);
        $entityManager->getManager()->flush();
        return true;
    }

    /**
     * @Rest\View()
     * @Rest\Put("/boisson/{id}")
     */
    public function updateBoissonAction(Request $request) {
        return true;
    }
}