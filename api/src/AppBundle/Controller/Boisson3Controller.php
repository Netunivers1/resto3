<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Boisson3;
use AppBundle\Form\Boisson3Type;

class Boisson3Controller extends Controller {

    /**
     * @Rest\View()
     * @Rest\Get("/boisson")
     */
    public function getBoissonAction(Request $request) {
        $Boisson3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Boisson3')
                ->findAll();

        return $Boisson3;
    }

     /**
     * @Rest\View()
     * @Rest\Post("/boisson")
     */
    public function postBoissonAction(Request $request) {
        $Boisson3 = new Boisson3();
        $form = $this->createForm(Boisson3Type::class, $Boisson3);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($Boisson3);
            $em->flush();
            return $Boisson3;
        } else {
            return $form;
        }
    }

     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/boisson/{id}")
     */
    public function removeBoissonAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $Boisson3 = $em->getRepository('AppBundle:Boisson3')
                    ->find($request->get('id'));

        if ($Boisson3) {
            $em->remove($Boisson3);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/boisson/{id}")
     */
    public function updateBoissonAction(Request $request) {
        $Boisson3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Boisson3')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        if (empty($Boisson3)) {
            return new JsonResponse(
                ['message' => 'Entree non trouvé'], 
                Response::HTTP_NOT_FOUND
            );
        }

        $form = $this->createForm(Boisson3Type::class, $Boisson3);

         // Le paramètre false dit à Symfony de garder les valeurs dans notre 
         // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Boisson3);
            $em->flush();
            return $Boisson3;
        } else {
            return $form;
        }
    }


}