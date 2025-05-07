<?php
include 'db.php';
include 'navbar.php';

$success = false;
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mentor_id = $_POST['mentor_id'];
    $faculty_id = $_POST['faculty_id'];
    $topic_name = $_POST['topic'];
    $deadline = $_POST['deadline'];

    if ($mentor_id && $faculty_id && $topic_name && $deadline) {
        $stmt = $conn->prepare("INSERT INTO topics (topic_name, deadline, mentor_id, faculty_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $topic_name, $deadline, $mentor_id, $faculty_id);
        if ($stmt->execute()) {
            $success = true;
        } else {
            $error = "Failed to assign topic. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "All fields are required.";
    }
}

$mentors = $conn->query("SELECT id, name FROM mentors");
$faculties = $conn->query("SELECT id, name FROM faculty");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign Topic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Assign Topic to Mentor</h2>

            <?php if ($success): ?>
                <div class="alert alert-success text-center">✅ Topic assigned successfully!</div>
            <?php elseif (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Select Mentor:</label>
                    <select name="mentor_id" class="form-select" required>
                        <option value="">-- Select Mentor --</option>
                        <?php while ($row = $mentors->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Faculty:</label>
                    <select name="faculty_id" class="form-select" required>
                        <option value="">-- Select Faculty --</option>
                        <?php while ($row = $faculties->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Topic Title:</label>
                    <input type="text" name="topic" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline:</label>
                    <input type="date" name="deadline" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Assign Topic</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>