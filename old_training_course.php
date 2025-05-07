<?php
include 'navbar.php'; // If you have a navbar
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

            <!-- Card 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card video-card shadow-sm p-3 h-100">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/2ePf9rue1Ao"
                        title="Teaching Skills" allowfullscreen></iframe>
                    <div class="card-body">
                        <h5 class="card-title">Effective Teaching Skills</h5>
                        <p class="card-text">Learn the core techniques to explain complex topics clearly and engage your
                            audience.</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card video-card shadow-sm p-3 h-100">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/S3Rmjm8NRI0"
                        title="Communication Skills" allowfullscreen></iframe>
                    <div class="card-body">
                        <h5 class="card-title">Mastering Communication</h5>
                        <p class="card-text">Improve your verbal and non-verbal communication for better mentor-mentee
                            relationships.</p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card video-card shadow-sm p-3 h-100">
                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/tgF1Enrgo2g"
                        title="Confidence Building" allowfullscreen></iframe>
                    <div class="card-body">
                        <h5 class="card-title">Building Confidence</h5>
                        <p class="card-text">Strategies to overcome stage fear and speak confidently during mentoring
                            sessions.</p>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>