<?php

namespace App\Controller;

use App\Entity\Recette;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InterController extends AbstractController
{
    #[Route('/inter', name: 'app_inter')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $anneeSelectionnee = $request->query->getInt('Annees', 2018); 
        $trimestreSelectionne = $request->query->get('trimestre', 1);


        $recettes = $doctrine->getRepository(Recette::class)->findBy(['Annees' => $anneeSelectionnee]);
        //$recettes = $doctrine->getRepository(Recette::class)->findAll();
        $trimestreSelectionne = $request->query->get('trimestre', 1);

        $trimestre = 'getTrimestre' . $trimestreSelectionne;
        $x = 0;
        foreach ($recettes as $recette) {
        $x = $recette->$trimestre();
        $y = $x * 0.4;
        $z = $y * 0.5; // sady Z prime
        $n = 1;
        $p = $z / $n;
        

    // POUR LES QUOTPART DR PRIME DE RESPONSABILITE (PR) ET PRIME DE TECHNICITE (PT)            
        $pr = $z * 0.3;
        $pt = $z * 0.25;
        $nic = $pt;
        $i = $z * 0.2;
        $total = $pr + $pt + $nic + $i;
        }

    //Initialisation tableau mère
        $sigle = ["X", "Y", "Z", "Z'", "N", "Fi"];
        $critere = [
            "Recette total RPE(sans pharmacie)",
            "40% de 'X'",
            "50% de 'Y' pour l'indice fixe",
            "50% de 'Y' pour les primes",
            "Nombre total des agents",
            "Quotepart de chacun  pour prime fixe P = Z/N"
        ];
        $pourcentage = ["-", "40%", "50%", "50%", "-", "-"];
        $montant = [$x, $y, $z, $z, $n, $p];

    //Initialisation tableau quotpart DR
        $sigle2 = ["PR", "PT", "NIC", "I", "TOTAL"];
        $critere2 = [
            "Prime de responsabilité PR (30%Z')",
            "Prime de technicité (25% Z')",
            "Note individuel du chef hierrarchique (25%Z')",
            "Indemnité de cession du comité de pilotage 20%Z')",
            "-",
        ];
        $pourcentage2 = ["30%", "25%", "25%", "20%", "100%"];
        $montant2 = [$pr, $pt, $nic, $i, $total];

    //Initialisation tableau du PR
        $tableauCp = [
            "CE", 
            "Adjoint Administratif chargé des affaires Médicales",
            "Adjoint Administratif chargé des affaires Financier",
            "Chef d'unité",
            "Professeur",
            "Médecin spécialiste",
            "Médecin généraliste",
            "Major des majors",
            "Chef division des administrations",
            "Surveillant des unités de soins",
            "Paramèdicaux - Assistantes sociale",
            "Sécretaire de direction",
            "Caissiers",
            "Vaguemestre-Secretaire-Documentaliste",
            "Technicien de surface-agent de maintenance-Aides",
            "Chauffeur-Ambulancier",
            "Chauffeur Administratif",
            "Agent de sécurité-Gardien",
            "Ouvrier-Serveur-Servant-Brancardier"
        ];
        $tableauR = [0.09, 0.07, 0.07, 0.09, 0.1, 0.09, 0.07, 0.06, 0.05, 0.06, 0.06, 0.03, 0.04, 0.02, 0.02, 0.02, 0.02, 0.02, 0.02,];
        $tableauMC = [];
        $tableauRi = [];
        $tableauT = [];
        $tableauTi = [];

    // Calcul prime de responsabilite
    foreach ($tableauR as $r) {
        $mc = $pr * $r;
        $ri = $mc / $n;
        $tableauMC[] = $mc;
        $tableauRi[] = $ri;
    }

    // Calcul prime de technicite
    foreach ($tableauR as $r) {
        $t = $pt * $r;
        $ti = $t / $n;
        $tableauT[] = $t;
        $tableauTi[] = $ti;
    }

    //Initialisation tableau de bonification
        $classe = ["Note 17 à 20", "Note 14 à 26", "Note 11 à 13"];
        $coefficient = [0.45, 0.35, 0.2];
        $montantM = [];
        $parIndividu = [];
    // Calcul de bonification
    foreach ($coefficient as $c) {
        $M = $nic * ($c*$n) / $c;
        $Pi = $M / $n;
        $montantM[] = $M;
        $parIndividu[] = $Pi;
    }
    $totalCo = array_sum($coefficient);
    $totalM = array_sum($montantM);
    $totalIndividu = array_sum($parIndividu);

    //Initialisation tableau pénalisation
        $quote = [];
        $gain = [];
        $p75 = [];
        $p50= [];
        $p25 = [];
    //Calcul pénalisation
    foreach ($tableauRi as $ri) {
        foreach ($tableauTi as $ti) {
            $QP = $p + $ri + $ti;
            $gc = $QP / $n;
            $psept = $QP * 0.25;
            $pcinq = $QP * 0.50;
            $pdeux = $QP * 0.75;
            $quote[] = $QP;
            $gain[] = $gc;
            $p75[] = $psept;
            $p50[] = $pcinq;
            $p25[] = $pdeux;
        }
    }
    $totalQ = array_sum($quote);
    $totalG = array_sum($gain);
    $total75 = array_sum($p75);
    $total50 = array_sum($p50);
    $total25 = array_sum($p25);

    $montantsTrimestre[] = $z;

        return $this->render('inter/index.html.twig', [
            'sigle' => $sigle, 'critere' => $critere, 'pourcentage' => $pourcentage, 'montant' => $montant,
            'sigle2' => $sigle2, 'critere2' => $critere2, 'pourcentage2' => $pourcentage2, 'montant2' => $montant2,
            'tableauR' => $tableauR, 'tableauMC' => $tableauMC, 'tableauRi' => $tableauRi, 'tableauCp' => $tableauCp, 'n' => $n, 'pr' => $pr,
            'pt' => $pt, 'tableauT' => $tableauT, 'tableauTi' => $tableauTi, 
            'classe' => $classe, 'coefficient' => $coefficient, 'montantM' => $montantM, 'parIndividu' => $parIndividu, 'nic' => $nic, 'totalCo' => $totalCo, 'totalM' => $totalM, 'totalIndividu' => $totalIndividu,
            'quote' => $quote, 'gain' => $gain, 'p75' => $p75, 'p50' => $p50, 'p25' => $p25, 'totalQ' => $totalQ, 'totalG' => $totalG, 'total75' => $total75, 'total50' => $total50, 'total25' => $total25,
        
            'trimestres' => [1, 2, 3, 4], // Les options du bouton de sélection
            'annee' => [2018, 2019, 2020, 2021], // Les options du bouton de sélection
            'trimestreSelectionne' => $trimestreSelectionne, 'anneeSelectionnee' => $anneeSelectionnee
        ]);
    }

}