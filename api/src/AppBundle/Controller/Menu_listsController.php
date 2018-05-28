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
     * @Rest\Get("/getlist/{menutitle}/{menuid}")
     */
    public function getListMenuAction($menutitle, $menuid) {
        $menu_repository = $this->getDoctrine()->getRepository(Menu_lists::class);
        $menu_name = $menu_repository->findBy(array('idMenu' => $menuid));
        $_menu_values = [];
        foreach ($menu_name as $key => $value) {
            $tmp_val = unserialize($value->getMenuLists());
            $tmp_val['id'] = $value->getId();
            array_push($_menu_values, $tmp_val);
        }
        return ($_menu_values) ? $_menu_values: false;
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