<?php
include 'db.php';
include 'navbar.php';

// Convert YouTube URL to embed format
function getEmbedLink($url)
{
    if (strpos($url, 'youtu.be/') !== false) {
        $parts = parse_url($url);
        $video_id = ltrim($parts['path'], '/');
        return "https://www.youtube.com/embed/" . $video_id;
    }
    if (strpos($url, 'watch?v=') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        return "https://www.youtube.com/embed/" . $query['v'];
    }
    if (strpos($url, 'embed/') !== false) {
        return $url;
    }
    return $url;
}

// Fetch distinct course names
$course_result = $conn->query("SELECT DISTINCT course_name FROM training_courses ORDER BY course_name ASC");

// Check if user clicked a course
$selected_course = isset($_GET['course']) ? $_GET['course'] : null;

$videos_result = null;
if ($selected_course) {
    $stmt = $conn->prepare("SELECT * FROM training_courses WHERE course_name = ?");
    $stmt->bind_param("s", $selected_course);
    $stmt->execute();
    $videos_result = $stmt->get_result();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Mentor Training Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .course-card,
        .video-card {
            transition: transform 0.3s;
        }

        .course-card:hover,
        .video-card:hover {
            transform: scale(1.03);
        }

        iframe {
            border-radius: 10px;
        }

        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h2 class="text-center mb-4">🎯 Mentor Training Courses</h2>

        <?php if ($selected_course): ?>
            <!-- Back Button -->
            <div class="text-start mb-4">
                <a href="training_courses.php" class="btn btn-secondary back-button">⬅️ Back to Courses</a>
            </div>

            <h3 class="mb-4 text-center"><?php echo htmlspecialchars($selected_course); ?> Videos</h3>

            <div class="row g-4">
                <?php while ($video = $videos_result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card video-card shadow-sm p-3 h-100">
                            <iframe width="100%" height="200"
                                src="<?php echo htmlspecialchars(getEmbedLink($video['youtube_link'])); ?>"
                                title="<?php echo htmlspecialchars($video['title']); ?>" allowfullscreen></iframe>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($video['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

        <?php else: ?>
            <!-- Show List of Courses -->
            <div class="row g-4">
                <?php while ($course = $course_result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="training_courses.php?course=<?php echo urlencode($course['course_name']); ?>"
                            class="text-decoration-none text-dark">
                            <div class="card course-card shadow-sm p-4 text-center h-100">
                                <h4><?php echo htmlspecialchars($course['course_name']); ?></h4>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>