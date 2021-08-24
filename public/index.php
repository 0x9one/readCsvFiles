<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

/* YOUR CODE (Instructions in README.md) */

require APP_PATH . 'App.php';
require APP_PATH . 'Helpers.php';


$files = getTransactionFiles(FILES_PATH);

// create a transaction variable have an empty array 
$transactions = [];

// we foreach the files and put each file to get extract and we merge it with the empty transactions array

foreach ($files as $file) {

    $transactions = array_merge($transactions, getTransactions($file, 'extractTransaction'));

}

$totals = calculateTotals($transactions);



require VIEWS_PATH . 'transactions.php';