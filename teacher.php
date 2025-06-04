<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lost_and_found";

$conn = new mysqli($servername, $username, $password, $dbname);

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = '';

// Handle "Mark as Claimed" action for both lost and found
if (
    isset($_POST['mark_claimed']) &&
    isset($_POST['claim_id']) &&
    isset($_POST['user_type']) &&
    isset($_POST['item_type'])
) {
    $claim_id = $_POST['claim_id'];
    $user_type = $_POST['user_type'];
    $item_type = $_POST['item_type'];
    $table = ($user_type === 'Teacher') ? 'teacher_personal_information_and_detail' : 'student_personal_info_and_detail';
    $id_field = ($user_type === 'Teacher') ? 'teacher_id' : 'student_id';
    // Set status to 'Claimed'
    $stmt = $conn->prepare("UPDATE $table SET status='Claimed' WHERE $id_field=? AND item_type=?");
    $stmt->bind_param("ss", $claim_id, $item_type);
    $stmt->execute();
    $stmt->close();
    // Redirect to avoid resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['mark_claimed'])) {
    $teacher_id = $_POST['teacher_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];
    $item_type = $_POST['item_type'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    // Always set to Unclaimed for both lost and found
    $status = 'Unclaimed';

    $stmt = $conn->prepare("INSERT INTO teacher_personal_information_and_detail (teacher_id, full_name, email, contact, gender, item_type, item_name, category, location, description, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $teacher_id, $full_name, $email, $contact, $gender, $item_type, $item_name, $category, $location, $description, $status);

    if ($stmt->execute()) {
        // Redirect to avoid resubmission on refresh
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lost & Found Board</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>📦 Lost & Found Board</h1>
    <p>Help your community reconnect with lost items</p>
    <button id="logoutBtn">Log Out</button>
  </header>

  <main>
    <?php if (!empty($success)): ?>
      <div class="modal" id="successModal" style="display:block;">
        <div class="modal-content">
          <h3>✅ Item Posted Successfully!</h3>
          <p>Thank you for being honest and helpful. The item is now listed below.</p>
          <button onclick="document.getElementById('successModal').style.display='none'">Close</button>
        </div>
      </div>
    <?php elseif (!empty($error)): ?>
      <div class="modal" style="display:block;">
        <div class="modal-content">
          <h3>❌ Error</h3>
          <p><?= $error ?></p>
          <button onclick="this.parentElement.parentElement.style.display='none'">Close</button>
        </div>
      </div>
    <?php endif; ?>

    <!-- Form to report lost/found items -->
    <section id="form-section">
      <h2>📝 Personal Information</h2>
      <form id="itemForm" method="POST" action="">
        <input type="text" name="teacher_id" placeholder="Teacher Id" required>
        <input type="text" name="full_name" placeholder="Full name" required>
        <input type="email" name="email" placeholder="School Email" required>
        <input type="text" name="contact" placeholder="Contact Number" required>

        <select name="gender" required>
          <option value="">Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>

        <h2>📦 Item Details</h2>
        <select name="item_type" required>
          <option value="">Select Type</option>
          <option value="lost">Lost</option>
          <option value="found">Found</option>
        </select>
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="text" name="category" placeholder="Category (e.g. phone, bag)" required>
        <input type="text" name="location" placeholder="Location Lost/Found" required>
        <textarea name="description" placeholder="Item Description"></textarea>

        <button type="submit">Post Item</button>
      </form>
    </section>

    <section id="items-list">
      <h2>🗂️ Listed Items</h2>
      <div id="cardsContainer">
        <?php
        // Combine teacher and student items, oldest first within type
        $teacher_sql = "SELECT 'Teacher' AS user_type, teacher_id AS id, full_name, email, contact, gender, item_type, item_name, category, location, description, status FROM teacher_personal_information_and_detail";
        $student_sql = "SELECT 'Student' AS user_type, student_id AS id, full_name, email, contact, gender, item_type, item_name, category, location, description, status FROM student_personal_info_and_detail";
        $sql = "$teacher_sql UNION ALL $student_sql ORDER BY item_type DESC, id ASC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $seen = [];
            while ($row = $result->fetch_assoc()) {
                // Prevent exact duplicates (same user_type, id, item_name, category, location)
                $unique_key = $row['user_type'] . '|' . $row['id'] . '|' . $row['item_name'] . '|' . $row['category'] . '|' . $row['location'];
                if (isset($seen[$unique_key])) continue;
                $seen[$unique_key] = true;

                // Always show Unclaimed or Claimed for both lost and found
                $status = (isset($row['status']) && $row['status'] === 'Claimed') ? 'Claimed' : 'Unclaimed';

                echo '<div class="card ' . htmlspecialchars($row['item_type']) . '">';
                echo '<h3>' . htmlspecialchars($row['item_name']) . ' (' . strtoupper(htmlspecialchars($row['item_type'])) . ')</h3>';
                echo '<p><strong>Posted by:</strong> ' . htmlspecialchars($row['full_name']) . ' (' . $row['user_type'] . ')</p>';
                echo '<p><strong>ID:</strong> ' . htmlspecialchars($row['id']) . '</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
                echo '<p><strong>Contact:</strong> ' . htmlspecialchars($row['contact']) . '</p>';
                echo '<p><strong>Gender:</strong> ' . htmlspecialchars($row['gender']) . '</p>';
                echo '<p><strong>Category:</strong> ' . htmlspecialchars($row['category']) . '</p>';
                echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
                echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
                echo '<p class="status-text"><strong>Status:</strong> ' . $status . '</p>';
                // Show "Mark as Claimed" button for both lost and found if status is Unclaimed
                if ($status === 'Unclaimed') {
                    echo '<form method="POST" action="" style="margin-top:10px;">
                            <input type="hidden" name="claim_id" value="' . htmlspecialchars($row['id']) . '">
                            <input type="hidden" name="user_type" value="' . htmlspecialchars($row['user_type']) . '">
                            <input type="hidden" name="item_type" value="' . htmlspecialchars($row['item_type']) . '">
                            <button type="submit" name="mark_claimed">Mark as Claimed</button>
                          </form>';
                }
                echo '</div>';
            }
        } else {
            echo "<p>No items posted yet.</p>";
        }
        ?>
      </div>
    </section>
  </main>

  <footer>
    <p>⚠️ Please be honest. Helping each other builds trust. | © 2025 Lost & Found System</p>
  </footer>

  <script>
    document.getElementById("logoutBtn").addEventListener("click", function () {
      window.location.href = "register.php";
    });
  </script>
</body>
</html>