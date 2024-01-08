<?php

namespace App\Controller;

use App\Entity\Produits;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    private $manager;
    public function __construct(ManagerRegistry $doctrine)
    {
     $this->manager = $doctrine->getManager();   
    }
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session): Response
    {
       $panier = $session->get('panier',[]);
     //  $session->invalidate();
     $total=$this->calculTotal($panier);
     $session->set('total_panier', $total);
        return $this->render('panier/index.html.twig', [
           'panier' => $panier,
           'total'=>$total
        ]);

    }
    private function calculTotal(array $panier): float
    {
        $total=0;
        foreach($panier as $produit)
        {
            $total += $produit['quantite']*$produit['prix'];
        }
        return $total;
    }
    #[Route('/panier/ajout/{idproduit}', name: 'app_panier_ajout')]
    public function ajoutPanier($idproduit,SessionInterface $session){
        $panier = $session->get('panier',[]);
        if(isset($panier[$idproduit]))
        {
            $panier[$idproduit]['quantite']++;
        }
        else{
            $produit=$this->manager->getRepository(Produits::class)->find($idproduit);
            if($produit)
            {$panier[$idproduit]=[
                'id'=>$produit->getId(),
                'quantite'=>1,
                'nom'=>$produit->getNom(),
                'prix'=>$produit->getPrix(),

            ];}     
    }
    $session->set('panier', $panier);
    $total=$this->calculTotal($panier);
    $session->set('total_panier', $total);
    return $this->redirectToRoute('app_panier',[
        'total'=>$total
    ]);
}
#[Route('/panier/supression/{produitId}', name: 'app_supression_panier')]
public function supressionPanier($produitId,SessionInterface $session){ 
    $panier = $session->get('panier',[]);
    if(isset($panier[$produitId])){
        unset($panier[$produitId]);
    }
    $session->set('panier',$panier);
    $total=$this->calculTotal($panier);
    $session->set('total_panier', $total);
    return $this->redirectToRoute('app_panier',[
        'total'=>$total
    ]);
}
#[Route('/panier/augmenter/{produitId}', name: 'app_augmenter_panier')]
public function augmenterPanier($produitId,SessionInterface $session)
{
    $panier = $session->get('panier',[]);
    if(isset($panier[$produitId])){
        $panier[$produitId]['quantite']++;
    }
    $session->set('panier',$panier);
    $total=$this->calculTotal($panier);
    $session->set('total_panier', $total);
    return $this->redirectToRoute('app_panier',[
        'total'=>$total
    ]);
}

#[Route('/panier/diminuer/{produitId}', name: 'app_diminuer_panier')]
public function diminuerPanier($produitId,SessionInterface $session)
{
    $panier = $session->get('panier',[]);
    if(isset($panier[$produitId]) && $panier[$produitId]['quantite']>1){
        $panier[$produitId]['quantite']--;
    }else {
        unset($panier[$produitId]);
    }
    $session->set('panier',$panier);
    $total=$this->calculTotal($panier);
    $session->set('total_panier', $total);
    return $this->redirectToRoute('app_panier',[
        'total'=>$total
    ]);
}


#[Route('/fermer', name: 'app_fermer_panier')]
public function fermerSession(SessionInterface $session)
{

    $session->invalidate();

    return $this->redirectToRoute('app_panier'); // Redirection vers une autre page
}
}
