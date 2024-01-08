<?php

namespace App\Controller;

use App\Entity\Avis;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AvisController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->manager = $doctrine->getManager();
    }

    #[Route('/Avis/{id}', name: 'app_avis')]
    public function index(Request $request): Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis, [
            'method' => 'GET'

        ]);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($avis);
            $this->manager->flush();

            $this->addFlash('success', 'avis ajouté');
            return $this->redirectToRoute('app_produits');
        }

        return $this->render('avis/avis.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
