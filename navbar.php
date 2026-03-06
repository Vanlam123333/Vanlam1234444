<?php
$current = basename($_SERVER['PHP_SELF']);
$user = getCurrentUser();
?>
<script>
  (function() {
    const t = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', t);
  })();
</script>

<!-- TOP NAVBAR (desktop) -->
<nav class="navbar">
  <a href="dashboard.php" class="logo">
    <div class="logo-icon">⚡</div>
    Mind<span>Spark</span>
  </a>

  <div class="nav-links">
    <a href="dashboard.php" class="nav-link <?= $current=='dashboard.php'?'active':'' ?>">📊 <span class="label">Dashboard</span></a>
    <a href="chat.php"      class="nav-link <?= $current=='chat.php'?'active':'' ?>">🧠 <span class="label">Chat AI</span></a>
    <a href="flashcard.php" class="nav-link <?= $current=='flashcard.php'?'active':'' ?>">⚡ <span class="label">Flashcard</span></a>
    <a href="quiz.php"      class="nav-link <?= $current=='quiz.php'?'active':'' ?>">🎯 <span class="label">Quiz</span></a>
    <a href="notes.php"     class="nav-link <?= $current=='notes.php'?'active':'' ?>">🗒️ <span class="label">Ghi chú</span></a>
    <a href="planner.php"   class="nav-link <?= $current=='planner.php'?'active':'' ?>">📅 <span class="label">Kế hoạch</span></a>
    <a href="math.php"      class="nav-link <?= $current=='math.php'?'active':'' ?>">📐 <span class="label">Toán</span></a>
  </div>

  <div class="nav-user">
    <button class="theme-toggle" onclick="toggleTheme()" id="themeBtn" title="Đổi theme">🌙</button>
    <div class="avatar"><?= strtoupper(mb_substr($user['name'], 0, 1)) ?></div>
    <span class="nav-name"><?= htmlspecialchars(explode(' ', $user['name'])[0]) ?></span>
    <a href="logout.php" class="btn-logout">Đăng xuất</a>
  </div>
</nav>

<!-- MOBILE TOP BAR -->
<div class="mobile-topbar">
  <a href="dashboard.php" class="logo">
    <div class="logo-icon">⚡</div>
    Mind<span>Spark</span>
  </a>
  <div style="display:flex;align-items:center;gap:8px;">
    <button class="theme-toggle" onclick="toggleTheme()" id="themeBtnMobile" title="Đổi theme">🌙</button>
    <div class="avatar"><?= strtoupper(mb_substr($user['name'], 0, 1)) ?></div>
  </div>
</div>

<!-- MOBILE BOTTOM NAV -->
<nav class="bottom-nav">
  <a href="dashboard.php" class="bottom-nav-item <?= $current=='dashboard.php'?'active':'' ?>">
    <span class="bottom-nav-icon">📊</span>
    <span class="bottom-nav-label">Home</span>
  </a>
  <a href="chat.php" class="bottom-nav-item <?= $current=='chat.php'?'active':'' ?>">
    <span class="bottom-nav-icon">🧠</span>
    <span class="bottom-nav-label">Chat</span>
  </a>
  <a href="flashcard.php" class="bottom-nav-item <?= $current=='flashcard.php'?'active':'' ?>">
    <span class="bottom-nav-icon">⚡</span>
    <span class="bottom-nav-label">Flash</span>
  </a>
  <a href="quiz.php" class="bottom-nav-item <?= $current=='quiz.php'?'active':'' ?>">
    <span class="bottom-nav-icon">🎯</span>
    <span class="bottom-nav-label">Quiz</span>
  </a>
  <button class="bottom-nav-item" onclick="toggleMoreMenu()">
    <span class="bottom-nav-icon">☰</span>
    <span class="bottom-nav-label">Thêm</span>
  </button>
</nav>

<!-- MORE MENU (mobile slide up) -->
<div class="more-overlay" id="moreOverlay" onclick="toggleMoreMenu()"></div>
<div class="more-menu" id="moreMenu">
  <div class="more-menu-handle"></div>
  <div class="more-menu-title">Menu</div>
  <div class="more-menu-grid">
    <a href="notes.php" class="more-menu-item" onclick="toggleMoreMenu()">
      <div class="more-menu-icon">🗒️</div>
      <div class="more-menu-label">Ghi chú</div>
    </a>
    <a href="planner.php" class="more-menu-item" onclick="toggleMoreMenu()">
      <div class="more-menu-icon">📅</div>
      <div class="more-menu-label">Kế hoạch</div>
    </a>
    <a href="math.php" class="more-menu-item" onclick="toggleMoreMenu()">
      <div class="more-menu-icon">📐</div>
      <div class="more-menu-label">Toán</div>
    </a>
    <a href="logout.php" class="more-menu-item">
      <div class="more-menu-icon">🚪</div>
      <div class="more-menu-label">Đăng xuất</div>
    </a>
  </div>
</div>

<script>
  function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme') || 'light';
    const next = current === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', next);
    localStorage.setItem('theme', next);
    const icon = next === 'dark' ? '☀️' : '🌙';
    const b1 = document.getElementById('themeBtn');
    const b2 = document.getElementById('themeBtnMobile');
    if (b1) b1.textContent = icon;
    if (b2) b2.textContent = icon;
  }

  function toggleMoreMenu() {
    const menu = document.getElementById('moreMenu');
    const overlay = document.getElementById('moreOverlay');
    const isOpen = menu.classList.contains('open');
    menu.classList.toggle('open', !isOpen);
    overlay.classList.toggle('open', !isOpen);
  }

  document.addEventListener('DOMContentLoaded', function() {
    const t = localStorage.getItem('theme') || 'light';
    const icon = t === 'dark' ? '☀️' : '🌙';
    const b1 = document.getElementById('themeBtn');
    const b2 = document.getElementById('themeBtnMobile');
    if (b1) b1.textContent = icon;
    if (b2) b2.textContent = icon;
  });
</script>
