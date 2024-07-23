<?php

$errors = []; // Array to store validation errors
$success_message = ''; // Variable to store success message

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate name
    if (empty($_POST['name'])) {
        $errors[] = "Name is required";
    } else {
        $name = test_input($_POST['name']);
        // Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors[] = "Only letters and white space allowed in name";
        }
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = "Email is required";
    } else {
        $email = test_input($_POST['email']);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
    }

    // Validate message
    if (empty($_POST['message'])) {
        $errors[] = "Message is required";
    } else {
        $message = test_input($_POST['message']);
    }

    // If no errors, process the form and show success message
    if (empty($errors)) {
        // You can process the form here (save to database, send email, etc.)
        $success_message = "Form submitted successfully!";
        
        // Clear form inputs after successful submission (optional)
        $name = $email = $message = '';
    }
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Validation</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Contact Us</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>"><br>
        <span class="error"><?php echo in_array("Name is required", $errors) ? "Name is required" : ""; ?></span><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>"><br>
        <span class="error"><?php echo in_array("Email is required", $errors) ? "Email is required" : ""; ?></span>
        <span class="error"><?php echo in_array("Invalid email format", $errors) ? "Invalid email format" : ""; ?></span><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message"><?php echo isset($message) ? $message : ''; ?></textarea><br>
        <span class="error"><?php echo in_array("Message is required", $errors) ? "Message is required" : ""; ?></span><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php if (!empty($success_message)): ?>
        
        <p><?php echo $success_message; ?></p>
    <?php endif; ?>
</body>
</html>
