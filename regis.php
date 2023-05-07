<?php
    // Validate input data and set default values
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
    $number = isset($_POST['number']) ? filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT) : '';
    $Event = isset($_POST['Event']) ? $_POST['Event'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    // Check if input data is valid
    if (empty($firstname) || empty($lastname) || empty($email) || empty($number) || empty($Event) || empty($gender)) {
        die('Please fill all required fields.');
    }

    // Connect to database
    $conn = new mysqli('localhost','root','','innovative');
    if($conn->connect_error){
        die('Connection failed: '.$conn->connect_error);
    }

    // Prepare SQL statement and insert data into database
    $stmt = $conn->prepare("INSERT INTO registration(firstname, lastname, email, number, Event, gender) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiss", $firstname, $lastname, $email, $number, $Event, $gender);
    if ($stmt->execute()) {
        echo "Registration successful";
    } else {
        echo "Error inserting data into database: ".$stmt->error;
    }
    $stmt->close();
    $conn->close();
?>
