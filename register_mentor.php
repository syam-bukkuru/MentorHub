<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $branch = $_POST['branch'];

    $stmt = $conn->prepare("INSERT INTO mentors (name, email, year, branch) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $year, $branch);
    $stmt->execute();
    $success = true;
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mentor Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Mentor Registration</h2>
            <?php if (!empty($success))
                echo "<div class='alert alert-success'>Mentor registered successfully!</div>"; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Year:</label>
                    <select name="year" class="form-select">
                        <option value="2nd">2nd</option>
                        <option value="3rd">3rd</option>
                        <option value="4th">4th</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Branch:</label>
                    <input type="text" name="branch" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>