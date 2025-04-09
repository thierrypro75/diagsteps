<?php

namespace App\Repository;

use App\Entity\DiagnosticSteps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiagnosticSteps>
 *
 * @method DiagnosticSteps|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiagnosticSteps|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiagnosticSteps[]    findAll()
 * @method DiagnosticSteps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiagnosticStepsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiagnosticSteps::class);
    }

    public function save(DiagnosticSteps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DiagnosticSteps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return DiagnosticSteps[] Returns an array of DiagnosticSteps objects for a given ProblemType, ordered by parent and then ID
     */
    public function findByProblemTypeOrdered($problemTypeId): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.problemType = :val')
            ->setParameter('val', $problemTypeId)
            // Order primarily by parent (nulls first), then by ID
            ->orderBy('d.parent', 'ASC') // Assuming nulls are treated as lowest
            ->addOrderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?DiagnosticSteps
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // Créer le code Mermaid pour représenter l'arbre de diagnostic d'un symptôme
    public function findMermaidCodeForSymptom(DiagnosticSteps $symptom): ?string
    {
        $collectedNodes = [];
        $collectedConnections = [];
        $visited = [];

        // Pass 1: Collect data starting from the symptom
        $this->collectTreeDataRecursive($symptom, $collectedNodes, $collectedConnections, $visited);

        if (empty($collectedNodes)) {
            return null; // No tree data found
        }

        // Pass 2: Generate Mermaid code
        $nodeDefinitions = [];
        $connectionDefinitions = [];
        $classAssignments = [];

        foreach ($collectedNodes as $nodeData) {
            $mermaidNodeId = 'node' . $nodeData['id'];
            // Use json_encode for robust escaping of description within quotes
            // JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_AMP are important for security if displaying in HTML
            $nodeLabel = json_encode($nodeData['description'] ?? '', JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_AMP);
            // Remove surrounding quotes added by json_encode as Mermaid adds its own delimiters
            $nodeLabel = trim($nodeLabel, '"'); 
            
            $nodeShape = '["' . $nodeLabel . '"]';
            if ($nodeData['type'] === 'check') {
                $nodeShape = '{"' . $nodeLabel . '"}';
            }

            $nodeDefinitions[] = $mermaidNodeId . $nodeShape;
            $classAssignments[] = $mermaidNodeId . ':::' . $nodeData['type'];
        }

        foreach ($collectedConnections as $connData) {
            $fromMermaidId = 'node' . $connData['from'];
            $toMermaidId = 'node' . $connData['to'];
            // Ensure target node was actually collected before creating connection
            if (isset($collectedNodes[$connData['to']])) {
                $arrow = $connData['label'] ? (' -- ' . $connData['label'] . ' --> ') : ' --> ';
                $connectionDefinitions[] = $fromMermaidId . $arrow . $toMermaidId;
            }
        }

        $classDefs = [
            'classDef symptome fill:#4e73df,stroke:#3b5bdb,color:#fff',
            'classDef check fill:#f6c23e,stroke:#dda20a,color:#333',
            'classDef action fill:#1cc88a,stroke:#13a16e,color:#fff'
        ];

        $mermaidCode = "flowchart TD\n"
            . implode("\n", $nodeDefinitions) . "\n"
            . implode("\n", $connectionDefinitions) . "\n"
            . implode("\n", $classAssignments) . "\n"
            . implode("\n", $classDefs);

        return $mermaidCode;
    }

    /**
     * Recursive helper function to collect node and connection data.
     */
    private function collectTreeDataRecursive(?DiagnosticSteps $node, array &$collectedNodes, array &$collectedConnections, array &$visited): void
    {
        if ($node === null || isset($visited[$node->getId()])) {
            return;
        }
        $visited[$node->getId()] = true;

        // Collect node
        if (!isset($collectedNodes[$node->getId()])) {
            $collectedNodes[$node->getId()] = [
                'id' => $node->getId(),
                'type' => $node->getType(),
                'description' => $node->getDescription()
            ];
        }

        // Collect connections and recurse
        $processChild = function (?DiagnosticSteps $childNode, ?string $label) use ($node, &$collectedNodes, &$collectedConnections, &$visited): void {
            if ($childNode !== null) {
                $connectionKey = $node->getId() . '-' . ($label ?? 'direct') . '-' . $childNode->getId();
                if (!isset($collectedConnections[$connectionKey])) {
                    $collectedConnections[$connectionKey] = [
                        'from' => $node->getId(),
                        'to' => $childNode->getId(),
                        'label' => $label
                    ];
                }
                // Pass the arrays by reference
                $this->collectTreeDataRecursive($childNode, $collectedNodes, $collectedConnections, $visited);
            }
        };

        // Process nextStep and nextStepKo (assuming no direct 'children' relationship is used for main tree flow)
        $processChild($node->getNextStep(), 'OK');
        $processChild($node->getNextStepKo(), 'KO');
    }
} 