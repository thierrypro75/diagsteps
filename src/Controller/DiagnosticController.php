<?php

namespace App\Controller;

use App\Entity\ProblemType;
use App\Entity\DiagnosticSteps;
use App\Repository\DiagnosticStepsRepository;
use App\Repository\ProblemTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiagnosticController extends AbstractController
{
    #[Route('/diagnostic', name: 'app_diagnostic_list')]
    public function list(ProblemTypeRepository $problemTypeRepository): Response
    {
        $problemTypes = $problemTypeRepository->findAll();

        return $this->render('diagnostic/list.html.twig', [
            'problemTypes' => $problemTypes,
        ]);
    }

    #[Route('/diagnostic/tree', name: 'app_diagnostic_tree', methods: ['GET'])]
    public function getDiagnosticTree(Request $request, DiagnosticStepsRepository $diagnosticStepsRepository): JsonResponse
    {
        $stepId = $request->query->get('stepId');

        if (!$stepId) {
            return new JsonResponse(['error' => 'Missing stepId parameter'], Response::HTTP_BAD_REQUEST);
        }

        $startStep = $diagnosticStepsRepository->find($stepId);

        if (!$startStep) {
            return new JsonResponse(['error' => 'Diagnostic step not found'], Response::HTTP_NOT_FOUND);
        }

        // Utiliser la nouvelle méthode du repository pour générer le code Mermaid
        $mermaidCode = $diagnosticStepsRepository->findMermaidCodeForSymptom($startStep);

        if ($mermaidCode === null) {
            return new JsonResponse(['error' => 'Could not generate Mermaid code for this step'], Response::HTTP_INTERNAL_SERVER_ERROR);
            // Ou retourner un code vide si c'est un cas attendu:
            // return new JsonResponse(['mermaidCode' => 'flowchart TD\n    message[\"Aucun arbre à afficher\"]']); 
        }

        return new JsonResponse(['mermaidCode' => $mermaidCode]);
    }

    #[Route('/diagnostic/{id}', name: 'app_diagnostic_index')]
    public function index(ProblemType $problemType, DiagnosticStepsRepository $diagnosticStepsRepository): Response
    {
        // No longer need to fetch steps here as the main list is static
        // $diagnosticSteps = $diagnosticStepsRepository->findByProblemTypeOrdered($problemType->getId());
        
        return $this->render('diagnostic/index.html.twig', [
            'problemType' => $problemType,
            // 'diagnosticSteps' => $diagnosticSteps, // Pass only problemType
        ]);
    }
    
    /**
     * Construit un arbre de diagnostic à partir d'une étape
     */
    private function buildDiagnosticTree(DiagnosticSteps $step): array
    {
        $tree = [
            'id' => $step->getId(),
            'description' => $step->getDescription(),
            'type' => $step->getType(),
            'needDoc' => $step->isNeedDoc(),
            'children' => [],
            'nextStep' => null,
            'nextStepKo' => null
        ];
        
        // Ajouter les enfants
        foreach ($step->getChildren() as $child) {
            $tree['children'][] = $this->buildDiagnosticTree($child);
        }
        
        // Ajouter nextStep s'il existe
        if ($step->getNextStep()) {
            $tree['nextStep'] = $this->buildDiagnosticTree($step->getNextStep());
        }
        
        // Ajouter nextStepKo s'il existe
        if ($step->getNextStepKo()) {
            $tree['nextStepKo'] = $this->buildDiagnosticTree($step->getNextStepKo());
        }
        
        return $tree;
    }
} 