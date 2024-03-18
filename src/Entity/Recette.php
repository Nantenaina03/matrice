<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Maternite = null;

    #[ORM\Column]
    private ?int $Medecine = null;

    #[ORM\Column(nullable: true)]
    private ?int $Actes_Chirurgicaux = null;

    #[ORM\Column(nullable: true)]
    private ?int $Pediatrie = null;

    #[ORM\Column(nullable: true)]
    private ?int $Ophtalmo = null;

    #[ORM\Column(nullable: true)]
    private ?int $ATU = null;

    #[ORM\Column(nullable: true)]
    private ?int $Banque_de_sang = null;

    #[ORM\Column(nullable: true)]
    private ?int $Tiers_service = null;

    #[ORM\Column(nullable: true)]
    private ?int $RPE_Actes = null;

    #[ORM\Column(nullable: true)]
    private ?int $CE_CM = null;

    #[ORM\Column(nullable: true)]
    private ?int $Part_med = null;

    #[ORM\Column(nullable: true)]
    private ?int $RPE = null;

    #[ORM\Column(nullable: true)]
    private ?int $ECG = null;

    #[ORM\Column(nullable: true)]
    private ?int $Echo = null;

    #[ORM\Column(nullable: true)]
    private ?int $Radio = null;

    #[ORM\Column(nullable: true)]
    private ?int $Labo = null;

    #[ORM\Column(nullable: true)]
    private ?int $Compte_LIM = null;

    #[ORM\Column(nullable: true)]
    private ?int $RPE_2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $Stomato = null;

    #[ORM\Column(nullable: true)]
    private ?int $Compte_stomato = null;

    #[ORM\Column(nullable: true)]
    private ?int $Compte_RPE = null;

    #[ORM\Column(nullable: true)]
    private ?int $Hebergement_salle_payante = null;

    #[ORM\Column(nullable: true)]
    private ?int $TOTAL_RPE = null;

    #[ORM\Column(nullable: true)]
    private ?int $RP_non_permanent = null;

    #[ORM\Column(nullable: true)]
    private ?int $RPE_instruction_permanent = null;

    #[ORM\Column(nullable: true)]
    private ?int $Autorise_fonctionnement = null;

    #[ORM\Column(nullable: true)]
    private ?int $Fond_de_secours = null;

    #[ORM\Column(nullable: true)]
    private ?int $Primes_rendement = null;

    #[ORM\Column(nullable: true)]
    private ?int $Compte_FEH = null;

    #[ORM\Column(nullable: true)]
    private ?int $Hebergement_salle_commune = null;

    #[ORM\Column(nullable: true)]
    private ?int $Marge_beneficiaire = null;

    #[ORM\Column(nullable: true)]
    private ?int $DONS = null;

    #[ORM\Column(nullable: true)]
    private ?int $Fonds_equite = null;

    #[ORM\Column]
    private ?int $Fonds_urgence = null;

    #[ORM\Column(nullable: true)]
    private ?int $Fonctionnement = null;

    #[ORM\Column(nullable: true)]
    private ?int $Primes_interessement = null;

    #[ORM\Column]
    private ?int $Mois = null;

    #[ORM\Column]
    private ?int $Annees = null;

    #[ORM\Column(nullable: true)]
    private ?int $trimestre1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $trimestre2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $trimestre3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $trimestre4 = null;

    #[ORM\ManyToOne(inversedBy: 'UserId')]
    private ?User $createdBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaternite(): ?int
    {
        return $this->Maternite;
    }

    public function setMaternite(int $Maternite): static
    {
        $this->Maternite = $Maternite;

        return $this;
    }

    public function getMedecine(): ?int
    {
        return $this->Medecine;
    }

    public function setMedecine(int $Medecine): static
    {
        $this->Medecine = $Medecine;

        return $this;
    }

    public function getActesChirurgicaux(): ?int
    {
        return $this->Actes_Chirurgicaux;
    }

    public function setActesChirurgicaux(?int $Actes_Chirurgicaux): static
    {
        $this->Actes_Chirurgicaux = $Actes_Chirurgicaux;

        return $this;
    }

    public function getPediatrie(): ?int
    {
        return $this->Pediatrie;
    }

    public function setPediatrie(?int $Pediatrie): static
    {
        $this->Pediatrie = $Pediatrie;

        return $this;
    }

    public function getOphtalmo(): ?int
    {
        return $this->Ophtalmo;
    }

    public function setOphtalmo(?int $Ophtalmo): static
    {
        $this->Ophtalmo = $Ophtalmo;

        return $this;
    }

    public function getATU(): ?int
    {
        return $this->ATU;
    }

    public function setATU(?int $ATU): static
    {
        $this->ATU = $ATU;

        return $this;
    }

    public function getBanqueDeSang(): ?int
    {
        return $this->Banque_de_sang;
    }

    public function setBanqueDeSang(?int $Banque_de_sang): static
    {
        $this->Banque_de_sang = $Banque_de_sang;

        return $this;
    }

    public function getTiersService(): ?int
    {
        return $this->Tiers_service;
    }

    public function setTiersService(?int $Tiers_service): static
    {
        $this->Tiers_service = $Tiers_service;

        return $this;
    }

    public function getRPEActes(): ?int
    {
        return $this->RPE_Actes;
    }

    public function setRPEActes(?int $RPE_Actes): static
    {
        $this->RPE_Actes = $RPE_Actes;

        return $this;
    }

    public function getCECM(): ?int
    {
        return $this->CE_CM;
    }

    public function setCECM(?int $CE_CM): static
    {
        $this->CE_CM = $CE_CM;

        return $this;
    }

    public function getPartMed(): ?int
    {
        return $this->Part_med;
    }

    public function setPartMed(?int $Part_med): static
    {
        $this->Part_med = $Part_med;

        return $this;
    }

    public function getRPE(): ?int
    {
        return $this->RPE;
    }

    public function setRPE(?int $RPE): static
    {
        $this->RPE = $RPE;

        return $this;
    }

    public function getECG(): ?int
    {
        return $this->ECG;
    }

    public function setECG(?int $ECG): static
    {
        $this->ECG = $ECG;

        return $this;
    }

    public function getEcho(): ?int
    {
        return $this->Echo;
    }

    public function setEcho(?int $ECO): static
    {
        $this->Echo = $ECO;

        return $this;
    }

    public function getRadio(): ?int
    {
        return $this->Radio;
    }

    public function setRadio(?int $Radio): static
    {
        $this->Radio = $Radio;

        return $this;
    }

    public function getLabo(): ?int
    {
        return $this->Labo;
    }

    public function setLabo(?int $Labo): static
    {
        $this->Labo = $Labo;

        return $this;
    }

    public function getCompteLIM(): ?int
    {
        return $this->Compte_LIM;
    }

    public function setCompteLIM(?int $Compte_LIM): static
    {
        $this->Compte_LIM = $Compte_LIM;

        return $this;
    }

    public function getRPE2(): ?int
    {
        return $this->RPE_2;
    }

    public function setRPE2(?int $RPE_2): static
    {
        $this->RPE_2 = $RPE_2;

        return $this;
    }

    public function getStomato(): ?int
    {
        return $this->Stomato;
    }

    public function setStomato(?int $Stomato): static
    {
        $this->Stomato = $Stomato;

        return $this;
    }

    public function getCompteStomato(): ?int
    {
        return $this->Compte_stomato;
    }

    public function setCompteStomato(?int $Compte_stomato): static
    {
        $this->Compte_stomato = $Compte_stomato;

        return $this;
    }

    public function getCompteRPE(): ?int
    {
        return $this->Compte_RPE;
    }

    public function setCompteRPE(?int $Compte_RPE): static
    {
        $this->Compte_RPE = $Compte_RPE;

        return $this;
    }

    public function getHebergementSallePayante(): ?int
    {
        return $this->Hebergement_salle_payante;
    }

    public function setHebergementSallePayante(?int $Hebergement_salle_payante): static
    {
        $this->Hebergement_salle_payante = $Hebergement_salle_payante;

        return $this;
    }

    public function getTOTALRPE(): ?int
    {
        return $this->TOTAL_RPE;
    }

    public function setTOTALRPE(?int $TOTAL_RPE): static
    {
        $this->TOTAL_RPE = $TOTAL_RPE;

        return $this;
    }

    public function getRPNonPermanent(): ?int
    {
        return $this->RP_non_permanent;
    }

    public function setRPNonPermanent(?int $RP_non_permanent): static
    {
        $this->RP_non_permanent = $RP_non_permanent;

        return $this;
    }

    public function getRPEInstructionPermanent(): ?int
    {
        return $this->RPE_instruction_permanent;
    }

    public function setRPEInstructionPermanent(?int $RPE_instruction_permanent): static
    {
        $this->RPE_instruction_permanent = $RPE_instruction_permanent;

        return $this;
    }

    public function getAutoriseFonctionnement(): ?int
    {
        return $this->Autorise_fonctionnement;
    }

    public function setAutoriseFonctionnement(?int $Autorise_fonctionnement): static
    {
        $this->Autorise_fonctionnement = $Autorise_fonctionnement;

        return $this;
    }

    public function getFondDeSecours(): ?int
    {
        return $this->Fond_de_secours;
    }

    public function setFondDeSecours(?int $Fond_de_secours): static
    {
        $this->Fond_de_secours = $Fond_de_secours;

        return $this;
    }

    public function getPrimesRendement(): ?int
    {
        return $this->Primes_rendement;
    }

    public function setPrimesRendement(?int $Primes_rendement): static
    {
        $this->Primes_rendement = $Primes_rendement;

        return $this;
    }

    public function getCompteFEH(): ?int
    {
        return $this->Compte_FEH;
    }

    public function setCompteFEH(?int $Compte_FEH): static
    {
        $this->Compte_FEH = $Compte_FEH;

        return $this;
    }

    public function getHebergementSalleCommune(): ?int
    {
        return $this->Hebergement_salle_commune;
    }

    public function setHebergementSalleCommune(?int $Hebergement_salle_commune): static
    {
        $this->Hebergement_salle_commune = $Hebergement_salle_commune;

        return $this;
    }

    public function getMargeBeneficiaire(): ?int
    {
        return $this->Marge_beneficiaire;
    }

    public function setMargeBeneficiaire(?int $Marge_beneficiaire): static
    {
        $this->Marge_beneficiaire = $Marge_beneficiaire;

        return $this;
    }

    public function getDONS(): ?int
    {
        return $this->DONS;
    }

    public function setDONS(?int $DONS): static
    {
        $this->DONS = $DONS;

        return $this;
    }

    public function getFondsEquite(): ?int
    {
        return $this->Fonds_equite;
    }

    public function setFondsEquite(?int $Fonds_equite): static
    {
        $this->Fonds_equite = $Fonds_equite;

        return $this;
    }

    public function getFondsUrgence(): ?int
    {
        return $this->Fonds_urgence;
    }

    public function setFondsUrgence(int $Fonds_urgence): static
    {
        $this->Fonds_urgence = $Fonds_urgence;

        return $this;
    }

    public function getFonctionnement(): ?int
    {
        return $this->Fonctionnement;
    }

    public function setFonctionnement(?int $Fonctionnement): static
    {
        $this->Fonctionnement = $Fonctionnement;

        return $this;
    }

    public function getPrimesInteressement(): ?int
    {
        return $this->Primes_interessement;
    }

    public function setPrimesInteressement(?int $Primes_interessement): static
    {
        $this->Primes_interessement = $Primes_interessement;

        return $this;
    }

    public function getMois(): ?int
    {
        return $this->Mois;
    }

    public function setMois(int $Mois): static
    {
        $this->Mois = $Mois;

        return $this;
    }

    public function getAnnees(): ?int
    {
        return $this->Annees;
    }

    public function setAnnees(int $Annees): static
    {
        $this->Annees = $Annees;

        return $this;
    }

    public function getTrimestre1(): ?int
    {
        return $this->trimestre1;
    }

    public function setTrimestre1(?int $trimestre1): static
    {
        $this->trimestre1 = $trimestre1;

        return $this;
    }

    public function getTrimestre2(): ?int
    {
        return $this->trimestre2;
    }

    public function setTrimestre2(?int $trimestre2): static
    {
        $this->trimestre2 = $trimestre2;

        return $this;
    }

    public function getTrimestre3(): ?int
    {
        return $this->trimestre3;
    }

    public function setTrimestre3(?int $trimestre3): static
    {
        $this->trimestre3 = $trimestre3;

        return $this;
    }

    public function getTrimestre4(): ?int
    {
        return $this->trimestre4;
    }

    public function setTrimestre4(?int $trimestre4): static
    {
        $this->trimestre4 = $trimestre4;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}