<?php
// SQLite path - dùng /tmp để Railway có thể ghi
$dbPath = getenv('RAILWAY_ENVIRONMENT') ? '/tmp/mindspark.db' : __DIR__ . '/mindspark.db';
$db = new SQLite3($dbPath);

// Tạo bảng nếu chưa có
$db->exec("
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS notes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    title TEXT,
    content TEXT,
    ai_summary TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS plans (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    date TEXT NOT NULL,
    subject TEXT,
    task TEXT,
    done INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS quiz_results (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    topic TEXT,
    score INTEGER,
    total INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS chat_history (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    role TEXT,
    content TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id)
);
");

function getCurrentUser() {
    if (isset($_SESSION['user_id'])) {
        global $db;
        $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindValue(':id', $_SESSION['user_id']);
        $result = $stmt->execute();
        return $result->fetchArray(SQLITE3_ASSOC);
    }
    return null;
}

function requireLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
?>
