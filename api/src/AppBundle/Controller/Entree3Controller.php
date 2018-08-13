<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Entree3;
use AppBundle\Form\Entree3Type;

class Entree3Controller extends Controller {

    /**
     * @Rest\View()
     * @Rest\Get("/entree/{paginate}/{page}/{limit}")
     */
    public function getMenuAction(Request $request, $paginate = 1, $page = 1, $limit = 5) {
        $Menu = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Entree3')
                ->createQueryBuilder('v');

        if ($paginate) {
            $Menu_clone = clone($Menu);
            $lists['count'] = (int) $Menu->select('COUNT(v) as list')->getQuery()->getResult()[0]['list'];

            // Check offset to be valid
            $limit = (int) $limit;
            $page = (int) $page;
            $page = ($page > 0 && $page <= ceil($lists['count'] / $limit)) ? $page : 1;
            $offset = ($page * $limit) - $limit;

            $lists['contain'] = $Menu_clone->setFirstResult($offset)->setMaxResults($limit)->getQuery()->getResult();

            $lists['p_current'] = $page;
            $lists['p_prev'] = $page - 1 < 0 ? $page : $page - 1;
            $lists['p_next'] = $page + 1 > $lists['contain'] ? $page : $page + 1;
        } else {
            $lists['contain'] = $Menu->getQuery()->getResult();
        }

        return $lists;
    }

     /**
     * @Rest\View()
     * @Rest\Post("/entree")
     */
    public function postEntreeAction(Request $request) {
        $Entree3 = new Entree3();
        $form = $this->createForm(Entree3Type::class, $Entree3);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($Entree3);
            $em->flush();
            return $Entree3;
        } else {
            return $form;
        }
    }

     /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/entree/{id}")
     */
    public function removeEntreeAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $Entree3 = $em->getRepository('AppBundle:Entree3')
                    ->find($request->get('id'));

        if ($Entree3) {
            $em->remove($Entree3);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/entree/{id}")
     */
    public function updateEntreeAction(Request $request) {
        $Entree3 = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Entree3')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire

        if (empty($Entree3)) {
            return new JsonResponse(
                ['message' => 'Entree non trouvé'], 
                Response::HTTP_NOT_FOUND
            );
        }

        $form = $this->createForm(Entree3Type::class, $Entree3);

         // Le paramètre false dit à Symfony de garder les valeurs dans notre 
         // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), false);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Entree3);
            $em->flush();
            return $Entree3;
        } else {
            return $form;
        }
    }


}