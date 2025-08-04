<?php
include 'db.php';
$result = $mysqli->query("SELECT * FROM abuse_reports WHERE status='approved' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Approved Rescue Posts</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
    .post { background: white; padding: 20px; margin-bottom: 15px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
    .post img { max-width: 200px; display: block; margin-top: 10px; }
    h2 { text-align: center; color: #333; }
  </style>
</head>
<body>
  <h2>Community Rescue & Abuse Reports</h2>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="post">
      <h3><?= htmlspecialchars($row['location']) ?></h3>
      <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
      <?php if (!empty($row['image'])): ?>
        <img src="<?= htmlspecialchars($row['image']) ?>" alt="Report Image">
      <?php endif; ?>
      <small><strong>Reported by:</strong> <?= htmlspecialchars($row['reporter_name']) ?></small>
    </div>
  <?php endwhile; ?>
</body>
</html>
