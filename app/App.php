<?php

declare(strict_types = 1);

// Your Code

// create a function that can read the files from the transaction directory 
    // we don't need a directory path we need just the files so that's way we use is_dir() function
    // we make the file path as a parameter and pass it cuz we don't want our function have a lot of responsibility and we make it easy to change 

function getTransactionFiles(string $dirPath): array
{

    $files = [];
    foreach(scandir($dirPath) as $file) {

        if (is_dir($file)) {
            continue;
        }

        $files[] = $dirPath . $file;
    }

    return $files;
}

// we want to read all these files and extract transaction

function getTransactions(string $fileName, ?callable $transactionHandler = null): array 
{
    // check if the file does not exists
    if(! file_exists($fileName)) {
        trigger_error('File ' . $fileName . ' does not exist ' , E_USER_ERROR);
    }

    // if file exists we will open it for reading
    $file = fopen($fileName, 'r');

    // we need to remove the first line because it's a title of the table values 
    fgetcsv($file);

    // we create transaction array and we will read file line by line and extract it in the transaction array
    $transactions = [];
    // because the files .csv we use fgetcsv() function

    while(($transaction = fgetcsv($file)) !== false) {

        if ($transactionHandler !== null) {
            $transaction = $transactionHandler($transaction);
        }

        $transactions[] = $transaction;
    }

    return $transactions;

}

// we have to formate a amount and add currency sign and change it from string to a number to make a calculations and we remove anu comma

function extractTransaction(array $transactionRow): array
{

    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $amount = (float) str_replace(['$', ','], '', $amount);

    return [
        'date'        => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount'      => $amount
    ];

}

// calculate a total 

function calculateTotals(array $transactions): array
{
    $totals = ['netTotal' => 0, 'totalIncome' =>  0, 'totalExpense' => 0];

    foreach ($transactions as $transaction) {
        $totals['netTotal'] += $transaction['amount'];

        if ($transaction['amount'] >= 0) {
            $totals['totalIncome'] += $transaction['amount'];
        } else {
            $totals['totalExpense'] += $transaction['amount'];
        }
    }

    return $totals;
}