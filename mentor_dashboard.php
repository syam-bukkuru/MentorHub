<?php
include 'db.php';
include 'navbar.php';

$mentor_email = '';
$mentor_id = '';
$mentor_name = '';
$topics = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mentor_email = $_POST['email'] ?? '';

    if (!empty($mentor_email)) {
        $mentor_query = $conn->prepare("SELECT id, name FROM mentors WHERE email = ?");
        $mentor_query->bind_param("s", $mentor_email);
        $mentor_query->execute();
        $mentor_result = $mentor_query->get_result();

        if ($mentor_result->num_rows > 0) {
            $mentor = $mentor_result->fetch_assoc();
            $mentor_id = $mentor['id'];
            $mentor_name = $mentor['name'];

            // Fetch assigned topics
            $topic_query = $conn->prepare("
                SELECT t.topic_name, t.deadline, f.name AS faculty_name
                FROM topics t
                JOIN faculty f ON t.faculty_id = f.id
                WHERE t.mentor_id = ?
            ");
            $topic_query->bind_param("i", $mentor_id);
            $topic_query->execute();
            $topic_result = $topic_query->get_result();

            while ($row = $topic_result->fetch_assoc()) {
                $topics[] = $row;
            }
        } else {
            $error = "No mentor found with this email.";
        }
    } else {
        $error = "Please enter your email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mentor Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar (already included via navbar.php) -->

    <!-- Mentor Dashboard -->
    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h2 class="text-center mb-4">🎓 Mentor Dashboard</h2>

            <!-- Email Form -->
            <form method="POST" action="" class="row g-3 justify-content-center mb-4">
                <div class="col-md-6">
                    <input type="email" name="email" class="form-control" placeholder="Enter your registered email"
                        required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Check Assignments</button>
                </div>
            </form>

            <!-- Show Errors -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <!-- If mentor found -->
            <?php if (!empty($mentor_name)): ?>
                <div class="text-center mb-4">
                    <h4>Hello, <span class="text-primary"><?php echo htmlspecialchars($mentor_name); ?></span> 👋</h4>
                </div>

                <!-- Topics Table -->
                <?php if (!empty($topics)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Topic</th>
                                    <th>Deadline</th>
                                    <th>Assigned By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($topics as $topic): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($topic['topic_name']); ?></td>
                                        <td><?php echo htmlspecialchars($topic['deadline']); ?></td>
                                        <td><?php echo htmlspecialchars($topic['faculty_name']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">No topics assigned yet.</div>
                <?php endif; ?>

                <!-- Buttons -->
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="index.php" class="btn btn-outline-primary">⬅️ Back to Home</a>
                    <a href="logout.php" class="btn btn-outline-danger">🔒 Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>