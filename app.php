<?php

ini_set('display_errors', true);
set_time_limit(600);
session_start();

require 'config.php';
require 'vendor/autoload.php';

function dd($content) {
    var_dump($content);
    die();
}

function logThis($message) {
    file_put_contents('sync.log', date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
    echo $message . PHP_EOL;
}

use Picqer\Api\Client as PicqerClient;

// Picqer connection
$picqerclient = new PicqerClient($config['picqer-company'], $config['picqer-apikey']);

if (!isset($_GET['step'])) {
    header('Location: app.php?step=upload');
    exit;
}

switch ($_GET['step']) {
    case 'upload':
        include('view-form.php');

        break;

    case 'preview':
        if (is_uploaded_file($_FILES['file']['tmp_name']) && isset($_POST['customerid']) && !empty($_POST['customerid'])) {
            $excelextrator = new PicqerImporter\SingleExcelExtractor($config);
            $products = $excelextrator->processExcel(
                $_FILES['file']['tmp_name']
            );

            $_SESSION['products'] = $products;
            $_SESSION['customerid'] = $_POST['customerid'];
            $_SESSION['reference'] = $_POST['reference'];

            include('view-preview.php');
        } else {
            include('view-no-data.php');
            exit;
        }

        break;

    case 'import':
        if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
            include('view-no-data.php');
            exit;
        }
        $importer = new PicqerImporter\SingleOrderImporter($picqerclient, $config);
        $orderid = $importer->importOrder($_SESSION['customerid'], $_SESSION['products'], $_SESSION['reference']);
        unset($_SESSION['products']);

        include('view-done.php');

        break;

    case 'cancel':
        unset($_SESSION['products']);
        header('Location: app.php?step=upload');
        exit;

        break;
}
