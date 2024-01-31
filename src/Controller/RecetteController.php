<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Recette')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'recette')] 
    public function Recette (ManagerRegistry $doctrine, Request $request): Response
    {
        
    // affichage des formulaires à remplir
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        

    // Calcul sur le premier tableau
        if ($form->isSubmitted() && $form->isValid())
        {
            $mois = $recette->getMois();
            $annees = $recette->getAnnees();
            $check = $doctrine->getRepository(Recette::class)->findOneBy([
                'Mois' => $mois,
                'Annees' => $annees
            ]);

            if($check){
                $this->addFlash(type:"error", message:"$mois $annees existe déjà");
                 // Réinitialiser le formulaire pour vider les champs
                $form = $this->createForm(RecetteType::class, new Recette());
            } else {
        // Calul RPE Actes 100%
            $RPE_Actes = $recette->getMaternite() + $recette->getMedecine() + $recette->getActesChirurgicaux() + $recette->getPediatrie() + $recette->getOphtalmo() + $recette->getATU() + $recette->getBanqueDeSang() + $recette->getTiersService();
            $recette->setRPEActes($RPE_Actes);

        // Calul Part Méd(60%)
            $Part_Med = $recette->getCECM() * 0.6;
            $recette->setPartMed($Part_Med);

        // Calul "RPE(40%)"
            $RPE = $recette->getCECM() * 0.4;
            $recette->setRPE($RPE);

        // Calul Compte LIM(60%)
            $CompteLIM = ($recette->getECG() + $recette->getEcho() + $recette->getRadio() + $recette->getLabo()) * 0.6 ;
            $recette->setCompteLIM($CompteLIM);

        // Calul "RPE(40%)" 2
            $RPE_2 = ($recette->getECG() + $recette->getEcho() + $recette->getRadio() + $recette->getLabo()) * 0.4;
            $recette->setRPE2($RPE_2);

        // Calul Compte Stomato
            $Compte_stomato = $recette->getStomato() * 0.75;
            $recette->setCompteStomato($Compte_stomato); 

        // Calul "Compte RPE (100%)"
            $Compte_RPE = $recette->getStomato() * 0.25;
            $recette->setCompteRPE($Compte_RPE);

        // Calul "TOTAL RPE (100%)"
            $TOTAL_RPE = $RPE_Actes + $RPE + $RPE_2 + $Compte_RPE + $recette->getHebergementSallePayante();
            $recette->setTOTALRPE($TOTAL_RPE);

        // Calul "Rénumération de personnel non permanent10% RPE total"
            $RP_non_permanent = $TOTAL_RPE * 0.1;
            $recette->setRPNonPermanent($RP_non_permanent);

        // Calul RPE à repartir selon instruction permanent
            $RPE_instruction_permanent = $TOTAL_RPE - $RP_non_permanent;
            $recette->setRPEInstructionPermanent($RPE_instruction_permanent);

        // Calul Autorisé pour le fonctionnement( 52% RPE)
            $Autoriser_pour_le_fonctionnement = $RPE_instruction_permanent * 0.52;
            $recette->setAutoriseFonctionnement($Autoriser_pour_le_fonctionnement);

        // Calul A verser pour fonds de secours(3% RPE)
            $Fonds_de_secours = $RPE_instruction_permanent * 0.03;
            $recette->setFondDeSecours($Fonds_de_secours);

        // Calul Primes de rendement (40% RPE)
            $Primes_de_rendement = $RPE_instruction_permanent * 0.4;
            $recette->setPrimesRendement($Primes_de_rendement);

        // Calul "Compte FEH (5% RPE)"
            $Compte_FEH = $RPE_instruction_permanent * 0.05;
            $recette->setCompteFEH($Compte_FEH);  

    // Calcul sur la deuxieme tableau
        //Calcul Fonds équité
            $Fonds_equite = ($RPE_instruction_permanent * 0.05) + ($recette->getMargeBeneficiaire() * 0.06) + $recette->getDONS();
            $recette->setFondsEquite($Fonds_equite);

        //Calcul Fonds d'urgence
            $Fonds_urgence = ($RPE_instruction_permanent * 0.03) + ($recette->getMargeBeneficiaire() * 0.03);
            $recette->setFondsUrgence($Fonds_urgence);

        //Calcul Fonctionnement 52%
            $Fonctionnement = $RPE_instruction_permanent * 0.52;
            $recette->setFonctionnement($Fonctionnement);

        //Calcul Primes, interessement
            $Primes_interessement = $RPE_instruction_permanent * 0.4;
            $recette->setPrimesInteressement($Primes_interessement); 


        // Enregistrement dans la base de données
            $manager = $doctrine->getManager();
            $manager->persist($recette);
            $manager->flush();

            
        //FlashBach
            $this->addFlash(
               'success',
               'Success'
            );
        // Réinitialiser le formulaire pour vider les champs
             $form = $this->createForm(RecetteType::class, new Recette());
        }
    }
    return $this->render('recette/insertion.html.twig', [
        'form' => $form->createView(),
    ]);
    }

    #[Route("/Affichage", name: "affichage")]
    public function afficherDonnees(ManagerRegistry $doctrine, Request $request): Response
    {
        $donnees = $doctrine->getRepository(Recette::class)->findAll();
    
        return $this->render('recette/Affichage.html.twig', [
            'donnees' => $donnees,
        ]);

    }
    #[Route("/Affichage/tab", name: "Tab")]
    public function Tab(ManagerRegistry $doctrine, Request $request): Response
    {
        $donnees = $doctrine->getRepository(Recette::class)->findAll();
    
        return $this->render('recette/Affichage.html.twig', [
            'donnees' => $donnees,
        ]);

    }
    
}