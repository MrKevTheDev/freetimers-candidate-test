<?php

use Kev\FreetimersCandidateTest\TopsoilCalculatorService;

require 'vendor/autoload.php'; // path to your autoload file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$dbService = new TopsoilCalculatorService();


// This function runs a migration
$dbService->createCalculationsTable();
