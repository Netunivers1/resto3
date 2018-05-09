<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Menu3;
use AppBundle\Form\Menu3Type;

class Menu3Controller extends Controller {

    /**
     * @Rest\View()
     * @Rest\Get("/menu3")
     */
    public function getMenuAction(Request $request) {
        $Menus = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Menu3')
                ->findAll();

        return $Menus;
    }

     /**
     * @Rest\View()
     * @Rest\Post("/menu3")
     */
    public function postMenuAction(Request $request) {
        $Menu3 = new Menu3();
        $form = $this->createForm(Menu3Type::class, $Menu3);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($Menu3);
            $em->flush();
            return $Menu3;
        } else {
            return $form;
        }
    }

     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/menu3/{id}")
     */
    public function removeMenuAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $Menu3 = $em->getRepository('AppBundle:Menu3')
                    ->find($request->get('id'));

        if ($Menu3) {
            $em->remove($Menu3);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/menu3/{id}")
     */
    public function updateMenuAction(Request $request) {
        $Menu3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Menu3')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        if (empty($Menu3)) {
            return new JsonResponse(
                ['message' => 'Menu3 non trouvé'], 
                Response::HTTP_NOT_FOUND
            );
        }

        $form = $this->createForm(Menu3Type::class, $Menu3);

         // Le paramètre false dit à Symfony de garder les valeurs dans notre 
         // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Menu3);
            $em->flush();
            return $Menu3;
        } else {
            return $form;
        }
    }


}