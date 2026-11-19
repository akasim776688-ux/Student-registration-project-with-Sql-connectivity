<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

require "db.php";

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$course = trim($_POST["course"] ?? "");

$allowedCourses = [
    "Computer Science",
    "Information Technology",
    "Software Engineering",
    "Artificial Intelligence"
];

$errors = [];

if ($name === "" || strlen($name) > 100) {
    $errors[] = "Please enter a name of up to 100 characters.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
    $errors[] = "Please enter a valid email address.";
}
if ($phone === "" || strlen($phone) > 25) {
    $errors[] = "Please enter a valid phone number.";
}
if (!in_array($course, $allowedCourses, true)) {
    $errors[] = "Please select a valid course.";
}

function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Result</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f6fb; margin: 0; padding: 30px; }
        .box { max-width: 520px; margin: 50px auto; background: white; padding: 28px; border-radius: 12px; box-shadow: 0 8px 28px rgba(0,0,0,.08); }
        h1 { color: #173b70; }
        .success { color: #166534; }
        .error { color: #b91c1c; }
        a { display: inline-block; margin-top: 18px; color: #1d4ed8; }
        li { margin: 8px 0; }
    </style>
</head>
<body>
<div class="box">
<?php if (!empty($errors)): ?>
    <h1 class="error">Registration not completed</h1>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= h($error) ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="index.html">Go back to the form</a>
<?php else: ?>
    <?php
    try {
        $sql = "INSERT INTO students (name, email, phone, course)
                VALUES (:name, :email, :phone, :course)";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ":name" => $name,
            ":email" => $email,
            ":phone" => $phone,
            ":course" => $course
        ]);
    ?>
        <h1 class="success">Registration successful!</h1>
        <p>Your details have been saved in the database.</p>
        <ul>
            <li><strong>Name:</strong> <?= h($name) ?></li>
            <li><strong>Email:</strong> <?= h($email) ?></li>
            <li><strong>Phone:</strong> <?= h($phone) ?></li>
            <li><strong>Course:</strong> <?= h($course) ?></li>
        </ul>
        <a href="index.html">Register another student</a>
    <?php
    } catch (PDOException $e) {
        error_log($e->getMessage());
        http_response_code(500);
        echo '<h1 class="error">Could not save registration</h1>';
        echo '<p>Please try again. If the problem continues, contact the administrator.</p>';
        echo '<a href="index.html">Return to form</a>';
    }
    ?>
<?php endif; ?>
</div>
</body>
</html>
