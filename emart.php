<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';
use MongoDB\Client;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); // Debug only

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    try {
        $client = new Client("mongodb://localhost:27017/");
        $collection = $client->emartdb->contacts;

        $insertResult = $collection->insertOne([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            echo "✅ Data saved successfully!";
        } else {
            echo "❌ Failed to insert data.";
        }
    } catch (Exception $e) {
        echo "❗ MongoDB Error: " . $e->getMessage();
    }
} else {
    echo "❌ Invalid request.";
}
?>
