<?php

namespace App\Controller;

use App\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class TrimestreController extends AbstractController
{
    #[Route('/trim', name: 'app_trim')]
    public function index(ManagerRegistry $doctrine): Response
    {

        // Récupérer les données de la base de données
        $trimestre = $doctrine->getRepository(Recette::class)->findAll();

        // Initialiser un tableau pour stocker les RPE par trimestre
        $rpeParTrimestre = [
            'trimestre1' => 0,
            'trimestre2' => 0,
            'trimestre3' => 0,
            'trimestre4' => 0,
        ];

        // Calculer la somme des RPE par trimestre
        foreach ($trimestre as $trim) {
            switch ($trim->getMois()) {
                case '1':
                case '2':
                case '3':
                    $rpeParTrimestre['trimestre1'] += $trim->getRPEInstructionPermanent();
                    break;
                case '4':
                case '5':
                case '6':
                    $rpeParTrimestre['trimestre2'] += $trim->getRPEInstructionPermanent();
                    break;
                case '7':
                case '8':
                case '9':
                    $rpeParTrimestre['trimestre3'] += $trim->getRPEInstructionPermanent();
                    break;
                case '10':
                case '11':
                case '12':
                    $rpeParTrimestre['trimestre4'] += $trim->getRPEInstructionPermanent();
                    break;
            }
        }

        // Afficher les résultats (vous pouvez les passer à une vue Twig si nécessaire)
        $mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

        return $this->render('/trimestre/index.html.twig', [
            'rpeParTrimestre' => $rpeParTrimestre,
            'trimestre' => $trimestre,
            'mois' => $mois,
        ]);
    }
}