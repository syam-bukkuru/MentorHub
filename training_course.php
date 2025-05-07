<?php
include 'db.php';
include 'navbar.php';

// Fetch videos from the database
$result = $conn->query("SELECT * FROM training_courses");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mentor Training Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .video-card {
            transition: transform 0.3s;
        }

        .video-card:hover {
            transform: scale(1.03);
        }

        iframe {
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center mb-4">🎯 Mentor Training Courses</h2>

        <div class="row g-4">

            <?php while ($video = $result->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card video-card shadow-sm p-3 h-100">
                        <iframe width="100%" height="200" src="<?php echo htmlspecialchars($video['youtube_link']); ?>"
                            title="<?php echo htmlspecialchars($video['title']); ?>" allowfullscreen></iframe>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($video['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>