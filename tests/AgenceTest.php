<?php
use PHPUnit\Framework\TestCase;

// On importe le modèle que l'on souhaite tester
require_once __DIR__ . '/../models/Agence.php';

class AgenceTest extends TestCase {

    // Le nom de la fonction doit obligatoirement commencer par "test"
    public function testAjouterAgence() {
        
        // 1. ARRANGE : Préparation des données
        $agenceModel = new Agence();
        // On génère un nom unique pour ne pas créer de doublons bloquants si on lance le test plusieurs fois
        $nomAgenceTest = "Agence_Test_" . uniqid(); 

        // 2. ACT : Exécution de la fonction d'écriture
        $resultat = $agenceModel->ajouterAgence($nomAgenceTest);

        // 3. ASSERT : Vérification
        // On s'attend à ce que $resultat soit "true" (la requête SQL a réussi)
        $this->assertTrue($resultat, "L'insertion en base de données a échoué.");
    }
}