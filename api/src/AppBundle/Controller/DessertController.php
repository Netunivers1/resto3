<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Dessert3;
use AppBundle\Form\Dessert3Type;

class DessertController extends Controller {

    /**
     * @Rest\View()
     * @Rest\Get("/dessert")
     */
    public function getDessertAction(Request $request) {
        $Dessert3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Dessert3')
                ->findAll();

        return $Dessert3;
    }

     /**
     * @Rest\View()
     * @Rest\Post("/dessert")
     */
    public function postDessertAction(Request $request) {
        $Dessert3 = new Dessert3();
        $form = $this->createForm(Dessert3Type::class, $Dessert3);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($Dessert3);
            $em->flush();
            return $Dessert3;
        } else {
            return $form;
        }
    }

     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/dessert/{id}")
     */
    public function removeDessertAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $Dessert3 = $em->getRepository('AppBundle:Dessert3')
                    ->find($request->get('id'));

        if ($Dessert3) {
            $em->remove($Dessert3);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/dessert/{id}")
     */
    public function updateDessertAction(Request $request) {
        $Dessert3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Dessert3')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        if (empty($Dessert3)) {
            return new JsonResponse(
                ['message' => 'Dessert non trouvé'], 
                Response::HTTP_NOT_FOUND
            );
        }

        $form = $this->createForm(Dessert3Type::class, $Dessert3);

         // Le paramètre false dit à Symfony de garder les valeurs dans notre 
         // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Dessert3);
            $em->flush();
            return $Dessert3;
        } else {
            return $form;
        }
    }


}