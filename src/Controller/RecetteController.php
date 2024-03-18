<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\User;
use App\Form\RecetteType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Recette'), 
IsGranted('ROLE_USER')]
class RecetteController extends AbstractController
{

    public function navigation(ManagerRegistry $doctrine): Response
    {
        // Récupérez le nom de l'utilisateur connecté
        $userConnecte = $this->getUser()->getUserIdentifier();
        
        // Récupérez le référentiel de l'entité User
        $repository = $doctrine->getRepository(User::class);
        
        // Recherchez l'utilisateur avec le nom d'utilisateur "Admin"
        $userNameConnecte = $repository->findOneBy(["username" => $userConnecte]);

        // Vérifiez si un utilisateur a été trouvé avec le nom "Admin"
        if ($userNameConnecte) {
            // Récupérez l'ID de l'utilisateur connecté
            $userId = $userNameConnecte->getId();
            
            // Retournez une réponse avec l'ID de l'utilisateur
            return new Response($userId);
        } else {
            // Si aucun utilisateur avec le nom "Admin" n'est trouvé, retournez une erreur 404
            throw $this->createNotFoundException('Utilisateur non trouvé avec le nom "Admin"');
        }
    }

   
    #[Route('/', name: 'recette')]
    public function Recette(ManagerRegistry $doctrine, Request $request): Response
    {
        // Appeler la fonction navigation pour obtenir l'ID de l'utilisateur connecté
        $userId = $this->navigation($doctrine)->getContent();
        
        $user = $this->getUser();
        // affichage des formulaires à remplir
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);


        // Calcul sur le premier tableau
        if ($form->isSubmitted() && $form->isValid()) {
            $mois = $recette->getMois();
            $annees = $recette->getAnnees();
            $check = $doctrine->getRepository(Recette::class)->findOneBy([
                'Mois' => $mois,
                'Annees' => $annees,
                'createdBy' => $user
            ]);
  
            $recette->setCreatedBy($user);
            
            if ($check) {
                $this->addFlash(type: "error", message: "$mois $annees existe déjà");
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
                $CompteLIM = ($recette->getECG() + $recette->getEcho() + $recette->getRadio() + $recette->getLabo()) * 0.6;
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
            'userId' => $userId
        ]);
    }

    //------------AFFICHAGE-------------------

    #[Route("/Affichage/{id<\d+>}", name: "affichage.id")]
    public function afficherDonnees(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        // Appeler la fonction navigation pour obtenir l'ID de l'utilisateur connecté
        $userId = $this->navigation($doctrine)->getContent();
        $repository = $doctrine->getRepository(Recette::class);
        $recette = $repository->findBy(["createdBy" => $id]);
        if (!$recette) {
            $this->addFlash('error', "L'urilisateur n'existe pas ");
            return $this->redirectToRoute('user.list');
        } else {
            
            $annee = $request->request->get('annee');
            $mois = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $donnees = array();

            foreach ($mois as $element) {
                $temp = $doctrine->getRepository(Recette::class)->findOneBy(
                    [
                        'Annees' => $annee,
                        'Mois' => $element
                    ]
                );

                if ($temp)
                    $donnees[$element] = $temp;
            }

            return $this->render('recette/Affichage.html.twig', [
                'donnees' => $donnees,
                'annees' => $annee,
                'mois' => $mois,
                'id' => $id,
                'userId' => $userId
            ]);
        }
    } 

    //-----------INTER---------------
     #[Route('/inter/{id<\d+>}', name: 'app_inter')]
    public function inter(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        // Appeler la fonction navigation pour obtenir l'ID de l'utilisateur connecté
        $userId = $this->navigation($doctrine)->getContent();

        $anneeSelectionnee = $request->query->getInt('Annees', 2018); 
        $trimestreSelectionne = $request->query->get('trimestre', 1);

        
        $recettes = $doctrine->getRepository(Recette::class)->findBy([
            "createdBy" => $id,
            'Annees' => $anneeSelectionnee
        ]);

        $trimestre = 'getTrimestre' . $trimestreSelectionne;

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

        return $this->render('recette/inter.html.twig', [
            'sigle' => $sigle, 'critere' => $critere, 'pourcentage' => $pourcentage, 'montant' => $montant,
            'sigle2' => $sigle2, 'critere2' => $critere2, 'pourcentage2' => $pourcentage2, 'montant2' => $montant2,
            'tableauR' => $tableauR, 'tableauMC' => $tableauMC, 'tableauRi' => $tableauRi, 'tableauCp' => $tableauCp, 'n' => $n, 'pr' => $pr,
            'pt' => $pt, 'tableauT' => $tableauT, 'tableauTi' => $tableauTi, 
            'classe' => $classe, 'coefficient' => $coefficient, 'montantM' => $montantM, 'parIndividu' => $parIndividu, 'nic' => $nic, 'totalCo' => $totalCo, 'totalM' => $totalM, 'totalIndividu' => $totalIndividu,
            'quote' => $quote, 'gain' => $gain, 'p75' => $p75, 'p50' => $p50, 'p25' => $p25, 'totalQ' => $totalQ, 'totalG' => $totalG, 'total75' => $total75, 'total50' => $total50, 'total25' => $total25, 
            'userId' => $userId, 
            'trimestres' => [1, 2, 3, 4], // Les options du bouton de sélection
            'annee' => [2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030], // Les options du bouton de sélection
            'trimestreSelectionne' => $trimestreSelectionne, 'anneeSelectionnee' => $anneeSelectionnee
        ]);
    }

    //-----------------TRIMESTRE-------------

    #[Route('/trimestre/{id<\d+>}', name: 'trimestre')]
    public function index(ManagerRegistry $doctrine, $id): Response
    {
        // Appeler la fonction navigation pour obtenir l'ID de l'utilisateur connecté
        $userId = $this->navigation($doctrine)->getContent();

        // Récupérer les données de la base de données
        $trimestre = $doctrine->getRepository(Recette::class)->findBy(["createdBy" => $id]);

        // Initialiser un tableau pour stocker les RPE par trimestre
        $rpeParTrimestre = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];
        $margeBeneficiaire = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];
        $dons = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];
        $fondsEquite = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];
        $fondsUrgence = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];
        $fonctionnement = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];
        $primesInteressement = ['trimestre1' => 0, 'trimestre2' => 0, 'trimestre3' => 0, 'trimestre4' => 0,];

        $totalRpeParTrimestre = 0;
        $totalMargeBeneficiaire = 0;
        $totalDons = 0;
        $totalFondsEquite = 0;
        $totalFondsUrgence = 0;
        $totalFonctionnement = 0;
        $totalPrimesInteressement = 0;
        // Calculer la somme des RPE par trimestre
        foreach ($trimestre as $trim) {
            switch ($trim->getMois()) {
                case '1':
                case '2':
                case '3':
                    $rpeParTrimestre['trimestre1'] += $trim->getRPEInstructionPermanent();
                    $margeBeneficiaire['trimestre1'] += $trim->getMargeBeneficiaire();
                    $dons['trimestre1'] += $trim->getDons();
                    $fondsEquite['trimestre1'] += $trim->getFondsEquite();
                    $fondsUrgence['trimestre1'] += $trim->getFondsUrgence();
                    $fonctionnement['trimestre1'] += $trim->getFonctionnement();
                    $primesInteressement['trimestre1'] += $trim->getPrimesInteressement();
                    break;
                case '4':
                case '5':
                case '6':
                    $rpeParTrimestre['trimestre2'] += $trim->getRPEInstructionPermanent();
                    $margeBeneficiaire['trimestre2'] += $trim->getMargeBeneficiaire();
                    $dons['trimestre2'] += $trim->getDons();
                    $fondsEquite['trimestre2'] += $trim->getFondsEquite();
                    $fondsUrgence['trimestre2'] += $trim->getFondsUrgence();
                    $fonctionnement['trimestre2'] += $trim->getFonctionnement();
                    $primesInteressement['trimestre2'] += $trim->getPrimesInteressement();
                    break;
                case '7':
                case '8':
                case '9':
                    $rpeParTrimestre['trimestre3'] += $trim->getRPEInstructionPermanent();
                    $margeBeneficiaire['trimestre3'] += $trim->getMargeBeneficiaire();
                    $dons['trimestre3'] += $trim->getDons();
                    $fondsEquite['trimestre3'] += $trim->getFondsEquite();
                    $fondsUrgence['trimestre3'] += $trim->getFondsUrgence();
                    $fonctionnement['trimestre3'] += $trim->getFonctionnement();
                    $primesInteressement['trimestre3'] += $trim->getPrimesInteressement();
                    break;
                case '10':
                case '11':
                case '12':
                    $rpeParTrimestre['trimestre4'] += $trim->getRPEInstructionPermanent();
                    $margeBeneficiaire['trimestre4'] += $trim->getMargeBeneficiaire();
                    $dons['trimestre4'] += $trim->getDons();
                    $fondsEquite['trimestre4'] += $trim->getFondsEquite();
                    $fondsUrgence['trimestre4'] += $trim->getFondsUrgence();
                    $fonctionnement['trimestre4'] += $trim->getFonctionnement();
                    $primesInteressement['trimestre4'] += $trim->getPrimesInteressement();
                    break;
            }
            $totalRpeParTrimestre = $rpeParTrimestre['trimestre1'] + $rpeParTrimestre['trimestre2'] + $rpeParTrimestre['trimestre3'] + $rpeParTrimestre['trimestre4'];
            $totalMargeBeneficiaire = $margeBeneficiaire['trimestre1'] + $margeBeneficiaire['trimestre2'] + $margeBeneficiaire['trimestre3'] + $margeBeneficiaire['trimestre4'];
            $totalDons = $dons['trimestre1'] + $dons['trimestre2'] + $dons['trimestre3'] + $dons['trimestre4'];
            $totalFondsEquite = $fondsEquite['trimestre1'] + $fondsEquite['trimestre2'] + $fondsEquite['trimestre3'] + $fondsEquite['trimestre4'];
            $totalFondsUrgence = $fondsUrgence['trimestre1'] + $fondsUrgence['trimestre2'] + $fondsUrgence['trimestre3'] + $fondsUrgence['trimestre4'];
            $totalFonctionnement = $fonctionnement['trimestre1'] + $fonctionnement['trimestre2'] + $fonctionnement['trimestre3'] + $fonctionnement['trimestre4'];
            $totalPrimesInteressement = $primesInteressement['trimestre1'] + $primesInteressement['trimestre2'] + $primesInteressement['trimestre3'] + $primesInteressement['trimestre4'];

            $trim->setTrimestre1($rpeParTrimestre['trimestre1']);
            $trim->setTrimestre2($rpeParTrimestre['trimestre2']);
            $trim->setTrimestre3($rpeParTrimestre['trimestre3']);
            $trim->setTrimestre4($rpeParTrimestre['trimestre4']);
        }

        // Enregistrement dans la bd
        $manager = $doctrine->getManager();
        foreach ($trimestre as $trim) {
            $manager->persist($trim);
        }
        $manager->flush();

        // Afficher les résultats
        $mois = ["Janvier", "Février", "Mars", "Trimestre1", "Avril", "Mai", "Juin","Trimestre2", "Juillet", "Août", "Septembre","Trimestre3", "Octobre", "Novembre", "Décembre", "Trimestre4"];

        return $this->render('recette/trimestre.html.twig', 
        [
            'rpeParTrimestre' => $rpeParTrimestre, 'margeBeneficiaire' => $margeBeneficiaire, 'dons' => $dons, 'fondsEquite' => $fondsEquite, 
                'fondsUrgence' => $fondsUrgence, 'fonctionnement' => $fonctionnement, 'primesInteressement' => $primesInteressement,
            'totalRpeParTrimestre' => $totalRpeParTrimestre, 'totalMargeBeneficiaire' => $totalMargeBeneficiaire, 'totalDons' => $totalDons, 'totalFondsEquite' => $totalFondsEquite,
                'totalFondsUrgence' => $totalFondsUrgence, 'totalFonctionnement' => $totalFonctionnement, 'totalPrimesInteressement' => $totalPrimesInteressement,
            'trimestre' => $trimestre,
            'mois' => $mois,
            'userId' => $userId
        ]);
    }
}