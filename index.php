<?php

require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->myDatabase->myCollection;

$name = $surname = $idNumber = $dob = '';
$hasError = false; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $idNumber = $_POST['idNumber'] ?? '';
    $dob = $_POST['dob'];

    if (empty($name) || empty($surname) || empty($dob)) {
        echo "ERROR: All fields are required to submit.";
        $hasError = true;
    }

    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
        echo "ERROR: Invalid date of birth format. Please use dd/mm/yyyy.";
        $hasError = true;
    }

    $dobTimestamp = strtotime(str_replace('/', '-', $dob));
    if ($dobTimestamp > time()) {
        echo "ERROR: Your date of birth cannot be in the future.";
        $hasError = true;
    }

    $dobParts = explode('/', $dob);
    $convertedDob = substr($dobParts[2], -2) . $dobParts[1] . $dobParts[0];

    $idDob = substr($idNumber, 0, 6);
    if ($convertedDob !== $idDob) {
        echo "ERROR: Your ID number does not match your date of birth or you have entered an invalid day or month.";
        $hasError = true;
    }

    if (preg_match('/\s/', $name) || preg_match('/\s/', $surname)) {
        echo "ERROR: Your name and surname fields should not contain whitespace.";
        $hasError = true;
    }

    if (preg_match('/[^a-zA-Z0-9\s]/', $name) || preg_match('/[^a-zA-Z0-9\s]/', $surname)) {
        echo "ERROR: Your name and surname fields should not contain special characters.";
        $hasError = true;
    }

    if (!ctype_alnum($idNumber) || strlen($idNumber) != 13) {
        echo "ERROR: Invalid ID number, please ensure that your ID number was entered correctly.";
        $hasError = true;
    }

    if (!$hasError) {
        $duplicate = $collection->findOne(['idNumber' => $idNumber]);
        if ($duplicate) {
            echo "ERROR: Duplicate ID number detected, please ensure that your ID number was entered correctly.";
            $hasError = true;
        }
    }

    if (!$hasError) {
        $insertOneResult = $collection->insertOne([
            'name' => $name,
            'surname' => $surname,
            'idNumber' => $idNumber,
            'dob' => $dob,
        ]);

        echo "SUCCESS: Your record has been inserted successfully.";
        $name = $surname = $idNumber = $dob = '';
    }
}

?>

<!doctype html>
<html>
<body>
<form method="post" action="">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>
    <label for="surname">Surname:</label><br>
    <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname); ?>" required><br>
    <label for="idNumber">ID Number:</label><br>
    <input type="text" id="idNumber" name="idNumber" value="<?php echo htmlspecialchars($idNumber); ?>" required><br>
    <label for="dob">Date of Birth:</label><br>
    <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" value="<?php echo htmlspecialchars($dob); ?>" required><br>
    <input type="submit" value="Submit">
    <input type="reset" value="Cancel">
</form>
</body>
</html>

