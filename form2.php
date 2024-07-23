<?php

$errors = [];
$success_message = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(empty($_POST["name"])) {
        $errors[] = "name is required";
    } else {
        $name = test_data($_POST["name"]);
    }

    if(empty($_POST["email"])) {
        $errors[] = "email is required";
    } else {
        $email = test_data($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "email is not valid";
        }
    }

    if(empty($_POST["message"])) {
        $errors[] = "message is required";
    } else {
        $message = test_data($_POST["message"]);
    }

    if(empty($erros)) {
        $success_message = "Form submitted sucessfully";
        $name = $email = $message = "";
    }
}


function test_data($data) {
    $data = trim($data);
    $data = stripslashes(($data));
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation in PHP</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Contact Details</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name</label><br>
        <input type="text" id="name" name="name" value="<?php isset($name) ? $name : "" ?>"/><br>
        <span class="error"><?php echo in_array("name is required", $errors) ? "Name is required" : "" ?></span><br>
        
        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="<?php isset($email) ? $email : "" ?>"/><br>
        <span class="error"><?php echo in_array("email is required", $errors) ? "Email is required" : "" ?></span><br>

        <label for="mesaage">Message</label><br>
        <textarea  id="message" name="message"><?php isset($message) ? $message : "" ?></textarea><br>
        <span class="error"><?php echo in_array("message is required", $errors) ? "Message is required" : "" ?></span><br>
        
        <input type="submit" name="submit" id="submit" value="Submit">
    </form>

    <?php
        if (!empty($success_message)) {
            header("Location: index.php");
            exit;
        }
    ?>
</body>
</html>
