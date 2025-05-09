<?php
include 'db.php';
include 'navbar.php';

// Function to convert YouTube URL to embed format
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
    return $url; // fallback
}

// Variables
$success = '';
$error = '';
$edit_mode = false;
$video_to_edit = [];

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM training_courses WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_training_courses.php");
    exit();
}

// Handle Edit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM training_courses WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $video_to_edit = $result->fetch_assoc();
    $stmt->close();
    $edit_mode = true;
}

// Handle Insert/Update Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $youtube_link = $_POST['youtube_link'];
    $course_name = $_POST['course_name'];

    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        // Update
        $edit_id = $_POST['edit_id'];
        $stmt = $conn->prepare("UPDATE training_courses SET title=?, description=?, youtube_link=?, course_name=? WHERE id=?");
        $stmt->bind_param("ssssi", $title, $description, $youtube_link, $course_name, $edit_id);
        if ($stmt->execute()) {
            $success = "Video updated successfully!";
        } else {
            $error = "Failed to update.";
        }
        $stmt->close();
        header("Location: manage_training_courses.php");
        exit();
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO training_courses (title, description, youtube_link, course_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $description, $youtube_link, $course_name);
        if ($stmt->execute()) {
            $success = "Video added successfully!";
        } else {
            $error = "Failed to add.";
        }
        $stmt->close();
    }
}

// Fetch all videos
$result = $conn->query("SELECT * FROM training_courses ORDER BY course_name, id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Training Videos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h2 class="text-center mb-4">🎯 Manage Training Videos</h2>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Add/Edit Form -->
        <div class="card shadow p-4 mb-5">
            <h4 class="mb-4"><?php echo $edit_mode ? "✏️ Edit Video" : "➕ Add New Video"; ?></h4>
            <form method="POST">
                <?php if ($edit_mode): ?>
                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($video_to_edit['id']); ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Course/Category Name</label>
                    <input type="text" name="course_name" class="form-control" required
                        value="<?php echo htmlspecialchars($video_to_edit['course_name'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Video Title</label>
                    <input type="text" name="title" class="form-control" required
                        value="<?php echo htmlspecialchars($video_to_edit['title'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="description" class="form-control" rows="3"
                        required><?php echo htmlspecialchars($video_to_edit['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">YouTube Link (any format)</label>
                    <input type="url" name="youtube_link" class="form-control" required
                        value="<?php echo htmlspecialchars($video_to_edit['youtube_link'] ?? ''); ?>">
                </div>
                <button type="submit" class="btn btn-<?php echo $edit_mode ? 'warning' : 'primary'; ?> w-100">
                    <?php echo $edit_mode ? "Update Video" : "Add Video"; ?>
                </button>
            </form>
        </div>

        <!-- List of Videos -->
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Course</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($video = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($video['id']); ?></td>
                            <td><?php echo htmlspecialchars($video['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($video['title']); ?></td>
                            <td><?php echo htmlspecialchars($video['description']); ?></td>
                            <td>
                                <iframe width="200" height="120"
                                    src="<?php echo htmlspecialchars(getEmbedLink($video['youtube_link'])); ?>"
                                    frameborder="0" allowfullscreen></iframe>
                            </td>
                            <td>
                                <a href="?edit_id=<?php echo $video['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="?delete_id=<?php echo $video['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this video?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>