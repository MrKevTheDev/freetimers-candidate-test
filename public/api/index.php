<?php
function dd(...$var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
use Kev\FreetimersCandidateTest\TopsoilCalculator;
use Kev\FreetimersCandidateTest\TopsoilCalculatorService;

require '../../vendor/autoload.php'; // path to your autoload file
$dotenv = Dotenv\Dotenv::createImmutable('../../');
$dotenv->load();

$dbService = new TopsoilCalculatorService();
$calculator = new TopsoilCalculator();

$json = file_get_contents('php://input');
// Decode the JSON string
$data = json_decode($json, true);

$action =  $_GET['action'] ?? '';

if ($action === 'calculate') {
    try {
        // Set units
        $calculator->setUnits(
            $data['units']['depthUnit'],
            $data['units']['lengthUnit'],
            $data['units']['widthUnit']
        );

        // Set dimensions (casting to integer for safety)
        $calculator->setDimensions(
            (int) $data['measurements']['length'],
            (int) $data['measurements']['width'],
            (int) $data['measurements']['depth']
        );

        // Calculate and encode data as JSON
        $jsonData = json_encode($calculator->calculateBags());

        // Set JSON content type header
        header('Content-Type: application/json');

        // Output the JSON data
        echo $jsonData;
    } catch (Exception $e) {
        // Handle potential exceptions during calculation (optional)
        echo json_encode(['error' => $e->getMessage()]);
    }
}

if ($action === 'save') {
    try {
        // Set units
        $calculator->setUnits(
            $data['units']['depthUnit'],
            $data['units']['lengthUnit'],
            $data['units']['widthUnit']
        );

        // Set dimensions (casting to integer for safety)
        $calculator->setDimensions(
            (int) $data['measurements']['length'],
            (int) $data['measurements']['width'],
            (int) $data['measurements']['depth']
        );

        // Calculate and encode data as JSON
        $jsonData = json_encode($calculator->saveToDatabase($dbService));

        // Set JSON content type header
        header('Content-Type: application/json');

        // Output the JSON data
        echo $jsonData;
    } catch (Exception $e) {
        // Handle potential exceptions during calculation (optional)
        echo json_encode(['error' => $e->getMessage()]);
    }
}


// This function runs a migration
/*$dbService->createCalculationsTable();*/

//Using database service with calculator class
/*$calculator->setUnits('m','m','m');
 $calculator->saveToDatabase($dbService);*/