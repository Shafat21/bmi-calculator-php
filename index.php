<?php
require_once 'includes/auth.php'; // Ensure user is authenticated
require_once 'includes/db.php';   // Include the database connection
require 'includes/header.php';    // Include the header with the title and buttons

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $height = filter_var($_POST['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $weight = filter_var($_POST['weight'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
    $sex = filter_var($_POST['sex'], FILTER_SANITIZE_STRING);
    $waist = filter_var($_POST['waist'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $hip = filter_var($_POST['hip'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Ensure the user exists in the BMIUsers table
    $stmt = $pdo->prepare("SELECT BMIUserID FROM BMIUsers WHERE BMIUserID = ?");
    $stmt->execute([$_SESSION['bmi_user_id']]);
    $bmiUser = $stmt->fetch();

    if (!$bmiUser) {
        // Insert the user into BMIUsers if not already present
        $stmt = $pdo->prepare("INSERT INTO BMIUsers (Name, Age, Sex) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION['username'], $age, $sex]);
        $_SESSION['bmi_user_id'] = $pdo->lastInsertId(); // Update the session with the new BMIUserID
    }

    $curl = curl_init();

    $postData = [
        'weight' => ['value' => $weight, 'unit' => 'kg'],
        'height' => ['value' => $height, 'unit' => 'cm'],
        'sex' => $sex,
        'age' => $age,
        'waist' => $waist,
        'hip' => $hip
    ];

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://bmi.p.rapidapi.com/v1/bmi",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postData),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-rapidapi-host: bmi.p.rapidapi.com",
            "x-rapidapi-key: 6c65d7f277msh5f056a18cfe4ae7p1929a5jsn511f76ea7d2c"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "<script>Swal.fire('Error', 'cURL Error #: $err', 'error');</script>";
    } else {
        $bmiData = json_decode($response, true);

        if ($bmiData === null || !isset($bmiData['bmi']['value'])) {
            echo "<script>Swal.fire('Error', 'Failed to calculate BMI. Please check your inputs and try again.', 'error');</script>";
        } else {
            $bmi = $bmiData['bmi']['value'];
            $status = $bmiData['bmi']['status'];
            $risk = $bmiData['bmi']['risk'];
            $idealWeight = $bmiData['ideal_weight'];

            // Insert into BMIRecords table
            $stmt = $pdo->prepare("INSERT INTO BMIRecords (BMIUserID, Height, Weight, BMI) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['bmi_user_id'], $height, $weight, $bmi]);

            // Display the extracted information in a SweetAlert
            echo "<script>
            Swal.fire({
                title: 'BMI Result',
                html: '<p><strong>BMI:</strong> " . round($bmi, 2) . "</p>' +
                      '<p><strong>Status:</strong> " . htmlspecialchars($status) . "</p>' +
                      '<p><strong>Risk:</strong> " . htmlspecialchars($risk) . "</p>' +
                      '<p><strong>Ideal Weight:</strong> " . htmlspecialchars($idealWeight) . "</p>',
                icon: 'success'
            });
            </script>";
        }
    }
}

// Display the History and Logout buttons if the user is logged in
if (isset($_SESSION['user_id'])) {
    echo '<div class="text-center my-4">';
    echo '<a href="views/history.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4 shadow">';
    echo 'History';
    echo '</a>';
    echo '<a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">';
    echo 'Logout';
    echo '</a>';
    echo '</div>';
}

require 'views/calculate_form.php'; // Include the BMI calculation form

// Footer inclusion is not necessary based on your latest preferences
?>
