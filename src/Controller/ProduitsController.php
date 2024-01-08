<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\Produits;
use App\Form\ProduitsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProduitsController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $doctrine)
    {$this->manager = $doctrine->getManager();

    }
    #[Route('/produits', name: 'app_produits')]
    public function index(Request $request,SluggerInterface $slugger): Response
    {
       $produits = new Produits;
       $form=$this->createForm(ProduitsType::class,$produits);
       $form->handleRequest($request); 

       if ($form->isSubmitted() && $form->isValid()) {
        $newPhotoFile = $form->get('photo')->getData();

        if ($newPhotoFile) {
            $cheminOrigine = pathinfo($newPhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($cheminOrigine);
            $nouveauChemin = $safeFilename . '-' . uniqid() . '.' . $newPhotoFile->guessExtension();

            try {
                $newPhotoFile->move(
                    $this->getParameter('IMG_URL_PRODUIT'),
                    $nouveauChemin
                );
            } catch (FileException $e) {
                $this->addFlash('error', 'Une erreur est survenue : ' . $e->getMessage());
                return $this->redirectToRoute('app_produits');
            }
            $produits->setPhoto($nouveauChemin);
        }
        $this->manager->persist($produits);
        $this->manager->flush();
        return $this->redirectToRoute('app_produits', []);
    }
        return $this->render('produits/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/produits/affichage', name: 'app_affichage_produits')]
    public function affichageProduit(): Response
    {
        $produits=$this->manager->getRepository(Produits::class)->findAll();
        return $this->render('produits/affichageProduit.html.twig',[
         "produits"=>$produits   
        ]);
        
    }
    #[Route('produits/detail/{id}',name: 'app_produits_detail')]
    public function produitsDetail($id,Request $request): Response

    {
        $user = $this->getUser();
        $detail = $this->manager->getRepository(Produits::class)->find($id);
        $avis = new Avis();
        $avis->setUser($user);
        $avis->setProduits($detail);
        $avis->setDateAvis(new \DateTime('today'));
        $form = $this->createForm(AvisType::class, $avis, [
            'method' => 'GET'

        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($avis);
            $this->manager->flush();

            $this->addFlash('success', 'avis ajouté');
            return $this->redirectToRoute('app_produits_detail',['id'=>$id]);
        }
        //$commentaire = $this->manager->getRepository(Avis::class)->findAll();
        $commentaire = $detail->getAvis()->toArray();
        usort($commentaire, function($a,$b){
            return $a->getId()-$b->getId();
        });
        return $this->render('produits/detail.html.twig',[
            'detailProduits'=>$detail,
            'form'=> $form->createView(),
            'commentaire'=>$commentaire

        ]);
    }
    #[Route('/produit/modification/{id}', name: 'app_modification_produit')]
    public function modificationProduit(Produits $produit,Request $request,SluggerInterface $slugger): Response
    {


        $form=$this->createForm(ProduitsType::class,$produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPhotoFile = $form->get('photo')->getData();

            if ($newPhotoFile) {
                $cheminOrigine = pathinfo($newPhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($cheminOrigine);
                $nouveauChemin = $safeFilename . '-' . uniqid() . '.' . $newPhotoFile->guessExtension();

                try {
                    $newPhotoFile->move(
                        $this->getParameter('IMG_URL_PRODUIT'),
                        $nouveauChemin
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue : ' . $e->getMessage());
                    return $this->redirectToRoute('app_produits');
                }
                $produit->setPhoto($nouveauChemin);
            }
            $this->manager->persist($produit);
            $this->manager->flush();
            return $this->redirectToRoute('app_produits', []);
        }
        return $this->render('produits/modification.html.twig', [
            "form"=> $form->createView()


        ]);
    } 
}
