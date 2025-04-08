<?php

namespace App\Controller;

use App\Entity\ProblemType;
use App\Entity\DiagnosticSteps;
use App\Repository\DiagnosticStepsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiagnosticController extends AbstractController
{
    #[Route('/diagnostic/{id}', name: 'app_diagnostic')]
    public function index(ProblemType $problemType, DiagnosticStepsRepository $diagnosticStepsRepository): Response
    {
        // Récupérer toutes les étapes de diagnostic pour ce type de problème
        $diagnosticSteps = $diagnosticStepsRepository->findByProblemTypeOrdered($problemType);

        // Organiser les étapes par type
        $steps = [
            'symptome' => [],
            'check' => [],
            'action' => []
        ];

        foreach ($diagnosticSteps as $step) {
            $steps[$step->getType()][] = $step;
        }

        return $this->render('diagnostic/index.html.twig', [
            'problemType' => $problemType,
            'steps' => $steps
        ]);
    }
} 