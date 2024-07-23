<?php
session_start();
$errors = [];
$success = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(empty($_POST["name"])) {
        $errors[] = "name is required";
    } else {
        $name = test_data($_POST["name"]);
        if(!nameCheck($name)) {
            $errors[] = "name is not valid";
        }
    }

    if(empty($_POST["email"])) {
        $errors[] = "email is required";
    } else {
        $email = test_data($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "email is invalid";
        }
    }


    if(empty($_POST["password"])) {
        $errors[] = "password is required";
    } else {
        $password = test_data($_POST["password"]);
    }

    if(empty($_POST["confirm-password"])) {
        $errors[] = "password is required";
    } else {
        if(strlen($password) > 0 && $password !== $_POST["confirm-password"]) {
            $errors[] = "password does not matches";
        } elseif(!passwordChecker($password)) {
            $errors[] = "password is not secure";
        }
        $password = test_data($_POST["confirm-password"]);
    }

    $interest[] = isset($_POST["interests"]) ? $_POST["interests"] : [];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $city = isset($_POST["city"]) ? $_POST["city"] : "";

    if(empty($gender)) {
        $errors[] = "gender is required";
    }

    if(empty($interest)) {   
        $errors[] = "interests is required";
    }

    if(empty($city)) {
        $errors[] = "city is required";
    }

    if(empty($errors)) {
        $success = "done";
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['interest'] = implode(", ", $interest);
        $_SESSION['gender'] = $gender;
        $_SESSION['city'] = $city;
    }
}

function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function passwordChecker($password) {
    if(strlen($password) < 6) return false;
    $small = $cap = $num = $special = false;
    for($i = 0; $i < strlen($password); $i++) {
        if($password[$i] >= "A" && $password[$i] <= "Z") $cap = true;
        if($password[$i] >= "a" && $password[$i] <= "z") $small = true;
        if(strpos("!@#$%^&*()_=", $password[$i]) !== false) $special = true;
        if(strrpos("0123456789", $password[$i]) !== false) $num = true;
    }
    return $small && $cap && $num && $special;
}

function nameCheck($name) {
    if(strlen($name) > 14) return false;
    for($i = 0; $i < strlen($name); $i++) {
        if($name[$i] >= "A" && $name[$i] <= "Z") "";
        elseif($name[$i] >= "a" && $name[$i] <= "z") "";
        else return false;
    }
    return true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation using PHP</title>
    <style>
        .error {
            color: red;
        }
        .hero {
            border: 1px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
        }
    </style>
</head>
<body>
    <h2>Contact Details</h2>
    <div class="hero">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <label for="name">Name</label><br>
        <input id="name" name="name" type="text" value="<?php isset($name) ? $name : "" ?>"/><br>
        <span class="error"><?php echo in_array("name is required", $errors) ? "Name is required" : ""; ?></span><br>
        <span class="error"><?php echo in_array("name is not valid", $errors) ? "Name is not valid" : ""; ?></span><br>

        <label for="email">Email</label><br>
        <input id="email" name="email" type="email" value="<?php isset($email) ? $email : "" ?>"/><br>
        <span class="error"><?php echo in_array("email is required", $errors) ? "Email is required" : ""; ?></span><br>
        <span class="error"><?php echo in_array("email is invalid", $errors) ? "Email is invalid" : ""; ?></span><br>

        <label for="password">Password</label><br>
        <input id="password" name="password" type="password" value="<?php isset($password) ? $password : "" ?>"/><br>
        <span class="error"><?php echo in_array("password is required", $errors) ? "Password is required" : ""; ?></span><br>
        <span class="error"><?php echo in_array("password is not secure", $errors) ? "Password is not strong" : ""; ?></span><br>

        <label for="confirm-password">Confirm Password</label><br>
        <input id="confirm-password" name="confirm-password" type="password" value="<?php isset($password) ? $password : "" ?>"/><br>
        <span class="error"><?php echo in_array("password is required", $errors) ? "Password is required" : ""; ?></span><br>
        <span class="error"><?php echo in_array("password does not matches", $errors) ? "Password does not match" : ""; ?></span><br>
        <span class="error"><?php echo in_array("password is not secure", $errors) ? "Password is not strong" : ""; ?></span><br>
        
        <label for="gender">Gender</label><br>
        <input type="radio" id="male" name="gender" value="Male">
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="Female">
        <label for="female">Female</label><br><br>
        <span class="error"><?php echo in_array("gender is required", $errors) ? "Gender is required" : ""; ?></span><br>


        <label for="interests">Interests</label><br>
        <input type="checkbox" id="sports" name="interests" value="sports">
        <label for="sports">Sports</label>
        <input type="checkbox" id="music" name="interests" value="music">
        <label for="music">Music</label>
        <input type="checkbox" id="travel" name="interests" value="travel">
        <label for="travel">Travel</label><br><br>
        <span class="error"><?php echo in_array("interests is required", $errors) ? "Interests is required" : ""; ?></span><br>

        <label for="city">Country</label><br>
        <select name="city" id="lang">
            <option value="none" selected disabled hidden>Select City</option>
            <option name="city" value="USA">USA</option>
            <option name="city" value="Canada">Canada</option>
            <option name="city" value="UK">UK</option>
            <option name="city" value="Australia">Australia</option>
        </select>
        <span class="error"><?php echo in_array("city is required", $errors) ? "City is required" : ""; ?></span><br>
        <br><br>

        <input type="submit" id="submit" value="Submit"/><br>
        
    </form>
    </div>

    <?php 
        if(!empty($success)) {
            header("Location: success.php");
            exit;
        }
    ?>
</body>
</html>
