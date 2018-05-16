<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Plat3;
use AppBundle\Form\Plat3Type;

class Plat3Controller extends Controller {

    /**
     * @Rest\View()
     * @Rest\Get("/plat")
     */
    public function getPlatAction(Request $request) {
        $Plat = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Plat3')
                ->findAll();

        return $Plat;
    }

     /**
     * @Rest\View()
     * @Rest\Post("/plat")
     */
    public function postPlatAction(Request $request) {
        $Plat3 = new Plat3();
        $form = $this->createForm(Plat3Type::class, $Plat3);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($Plat3);
            $em->flush();
            return $Plat3;
        } else {
            return $form;
        }
    }

     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/plat/{id}")
     */
    public function removePlatAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $Plat3 = $em->getRepository('AppBundle:Plat3')
                    ->find($request->get('id'));

        if ($Plat3) {
            $em->remove($Plat3);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/plat/{id}")
     */
    public function updatePlatAction(Request $request) {
        $Plat3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Plat3')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        if (empty($Plat3)) {
            return new JsonResponse(
                ['message' => 'Entree non trouvé'], 
                Response::HTTP_NOT_FOUND
            );
        }

        $form = $this->createForm(Plat3Type::class, $Plat3);

         // Le paramètre false dit à Symfony de garder les valeurs dans notre 
         // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Plat3);
            $em->flush();
            return $Plat3;
        } else {
            return $form;
        }
    }


}