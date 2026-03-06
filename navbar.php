<?php
$current = basename($_SERVER['PHP_SELF']);
$user = getCurrentUser();
?>
<nav class="navbar">
  <a href="dashboard.php" class="logo">Mind<span>Spark</span></a>
  <div class="nav-links">
    <a href="dashboard.php" class="nav-link <?= $current=='dashboard.php'?'active':'' ?>">📊 <span class="label">Dashboard</span></a>
    <a href="chat.php"      class="nav-link <?= $current=='chat.php'?'active':'' ?>">🧠 <span class="label">Chat</span></a>
    <a href="flashcard.php" class="nav-link <?= $current=='flashcard.php'?'active':'' ?>">⚡ <span class="label">Flashcard</span></a>
    <a href="quiz.php"      class="nav-link <?= $current=='quiz.php'?'active':'' ?>">🎯 <span class="label">Quiz</span></a>
    <a href="notes.php"     class="nav-link <?= $current=='notes.php'?'active':'' ?>">🗒️ <span class="label">Ghi chú</span></a>
    <a href="planner.php"   class="nav-link <?= $current=='planner.php'?'active':'' ?>">📅 <span class="label">Kế hoạch</span></a>
    <a href="math.php"      class="nav-link <?= $current=='math.php'?'active':'' ?>">📐 <span class="label">Toán</span></a>
  </div>
  <div class="nav-user">
    <div class="avatar"><?= strtoupper(mb_substr($user['name'], 0, 1)) ?></div>
    <span style="font-family:var(--font-head);font-size:0.82rem;font-weight:700;"><?= htmlspecialchars($user['name']) ?></span>
    <a href="logout.php" class="btn-logout">Đăng xuất</a>
  </div>
</nav>
