<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Repository\UserRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index(GroupeRepository $groupeRepo, UserRepository $userrepo)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $groupeAll = $groupeRepo->findAll();
        $users = $userrepo->findAll();

        return $this->render('base.html.twig', [
            'groupes' => $groupeAll,
            'users' => $users
        ]);
    }
}
