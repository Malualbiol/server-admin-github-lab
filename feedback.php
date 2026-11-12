<?php
require "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $subject = trim($_POST["subject"]);
    $feedbackMessage = trim($_POST["message"]);

    $stmt = $conn->prepare(
        "INSERT INTO feedback (name, subject, message)
         VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $name, $subject, $feedbackMessage);

    if ($stmt->execute()) {
        $message = "Feedback submitted successfully!";
    } else {
        $message = "Submission failed: " . $stmt->error;
    }

    $stmt->close();
}

$result = $conn->query(
    "SELECT id, name, subject, message, created_at
     FROM feedback
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form</title>
</head>
<body>

<h2>Feedback Form</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Subject:</label><br>
    <input type="text" name="subject" required><br><br>

    <label>Message:</label><br>
    <textarea name="message" required></textarea><br><br>

    <button type="submit">Submit Feedback</button>
</form>

<hr>

<h2>Submitted Feedback</h2>

<?php while ($row = $result->fetch_assoc()): ?>

    <p>
        <strong><?php echo htmlspecialchars($row["name"]); ?></strong><br>
        Subject: <?php echo htmlspecialchars($row["subject"]); ?><br>
        Message: <?php echo htmlspecialchars($row["message"]); ?><br>
        Submitted: <?php echo htmlspecialchars($row["created_at"]); ?>
    </p>

<?php endwhile; ?>

</body>
</html>
