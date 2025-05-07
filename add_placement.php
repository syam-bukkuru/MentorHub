<?php
include 'db.php';
include 'navbar.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $company = $_POST['company'];
    $github_link = $_POST['github_link'];
    $linkedin_link = $_POST['linkedin_link'];

    // Handle Resume Upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $resume = $_FILES['resume'];
        $resume_name = time() . "_" . basename($resume['name']); // Unique file name
        $target_directory = "uploads/resumes/";
        $target_file = $target_directory . $resume_name;

        if (move_uploaded_file($resume['tmp_name'], $target_file)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO placements (student_name, company, github_link, linkedin_link, resume_link) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $student_name, $company, $github_link, $linkedin_link, $target_file);

            if ($stmt->execute()) {
                $success = "Placement added successfully!";
            } else {
                $error = "Database error!";
            }
            $stmt->close();
        } else {
            $error = "Failed to upload resume.";
        }
    } else {
        $error = "Please upload a resume (PDF).";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Placement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h2 class="text-center mb-4">Add Placed Student</h2>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success text-center">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Student Name:</label>
                    <input type="text" name="student_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Company:</label>
                    <input type="text" name="company" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">GitHub Profile Link:</label>
                    <input type="url" name="github_link" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">LinkedIn Profile Link:</label>
                    <input type="url" name="linkedin_link" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Resume (PDF only):</label>
                    <input type="file" name="resume" class="form-control" accept="application/pdf" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Add Placement</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>