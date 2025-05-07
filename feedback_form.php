<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mentor_id = $_POST['mentor_id'];
    $comments = $_POST['comments'];
    $score = $_POST['score'];

    $stmt = $conn->prepare("INSERT INTO feedback (mentor_id, faculty_comments, score) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $mentor_id, $comments, $score);
    $stmt->execute();
    $success = true;
    $stmt->close();
}

$mentors = $conn->query("SELECT id, name FROM mentors");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faculty Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Faculty Feedback Form</h2>
            <?php if (!empty($success))
                echo "<div class='alert alert-success'>Feedback submitted successfully!</div>"; ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Select Mentor:</label>
                    <select name="mentor_id" class="form-select">
                        <?php while ($row = $mentors->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Comments:</label>
                    <textarea name="comments" rows="4" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Score (out of 10):</label>
                    <input type="number" name="score" class="form-control" min="1" max="10" required>
                </div>
                <button type="submit" class="btn btn-warning w-100">Submit Feedback</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>