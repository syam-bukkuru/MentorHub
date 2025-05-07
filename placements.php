<?php
include 'db.php';
include 'navbar.php'; // Optional if you already have a navbar

// Fetch all placements
$result = $conn->query("SELECT * FROM placements ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Placement Success Wall</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center mb-4">🎉 Our Placed Students</h2>

        <div class="row g-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($row['student_name']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($row['company']) ?></p>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <a href="<?= htmlspecialchars($row['github_link']) ?>" target="_blank"
                                    class="btn btn-dark btn-sm">GitHub</a>
                                <a href="<?= htmlspecialchars($row['linkedin_link']) ?>" target="_blank"
                                    class="btn btn-primary btn-sm">LinkedIn</a>
                            </div>
                            <a href="<?= htmlspecialchars($row['resume_link']) ?>" target="_blank"
                                class="btn btn-outline-success btn-sm">📄 View Resume</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-outline-primary">⬅️ Back to Home</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>