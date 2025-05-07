<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mentor Hub - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include 'navbar.php'; ?> <!-- Including the navbar -->

    <div class="container mt-5">
        <div class="text-center">
            <h1 class="display-4">Welcome to Mentor Hub</h1>
            <p class="lead mt-3">Empowering Seniors to Guide Juniors!</p>
            <hr class="my-4">
            <p class="mt-4">
                <a class="btn btn-primary btn-lg me-2" href="register_mentor.php" role="button">Register as Mentor</a>
                <a class="btn btn-success btn-lg me-2" href="assign_topic.php" role="button">Assign Topics (Faculty)</a>
                <a class="btn btn-warning btn-lg" href="feedback_form.php" role="button">Give Feedback</a>
                <a class="btn btn-primary btn-lg me-2" href="mentor_dashboard.php" role="button">Mentor Dashboard</a>

            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>