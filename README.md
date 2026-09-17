# XING FU CHA — Bubble Tea Ordering System

PHP + MySQL bubble tea shop app. Customers order drinks, admins manage the shop.

## Requirements

- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.2+
- Composer 2.x

## Setup

```bash
# 1. Install
composer install
composer dump-autoload

# 2. Create database
sudo systemctl start mysql
sudo mysql -e "CREATE DATABASE IF NOT EXISTS drink_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
sudo mysql drink_db < drink_db.sql

# 3. Create app user
sudo mysql <<'SQL'
CREATE USER 'drink_user'@'localhost' IDENTIFIED BY 'DrinkPass_2026!';
GRANT ALL PRIVILEGES ON drink_db.* TO 'drink_user'@'localhost';
FLUSH PRIVILEGES;
SQL

# 4. Fix schema
sudo mysql drink_db <<'SQL'
ALTER TABLE users    ADD COLUMN remember_token VARCHAR(255) DEFAULT NULL;
ALTER TABLE users    ADD COLUMN updated_at     DATETIME     DEFAULT NULL;
ALTER TABLE products ADD COLUMN quantity       INT(11)      DEFAULT 0;
CREATE TABLE IF NOT EXISTS toppings (
    topping_id INT(11) NOT NULL AUTO_INCREMENT,
    topping_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (topping_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL

# 5. Set DB credentials in Database/database.php
#    username = 'drink_user'
#    password = 'DrinkPass_2026!'

# 6. Create router.php
cat > router.php <<'EOF'
<?php
chdir(__DIR__);
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $path;
if ($path !== '/' && file_exists($file) && !is_dir($file)) return false;
require __DIR__ . '/index.php';
EOF

# 7. Run
php -d display_errors=1 -d error_reporting=E_ALL -S localhost:8000 router.php
```

Open http://localhost:8000/

## Credentials

**Admin** — http://localhost:8000/admin-login
```
charyna.chab@student.passerellesnumeriques.org / ryna!@#1649
```

**User** — http://localhost:8000/login
```
romsreyneath4@gmail.com / 90909090
```

## Rules

- Folder must be `controllers/` (lowercase)
- After renaming files: `composer dump-autoload`
- Always run server with `-d display_errors=1`

## Common Errors

| Error | Fix |
|-------|-----|
| `Access denied for 'root'` | Use `drink_user` |
| `Unknown database` | Re-run step 2 |
| `Unknown column` / `Table doesn't exist` | Re-run step 4 |
| `Class not found` | `composer dump-autoload` |
| `404 Page Not Found` | Start with `router.php` |
| Blank page | Add `-d display_errors=1` |
| Folder `Controllers/` | `mv Controllers controllers` |

## Reset DB

```bash
sudo mysql -e "DROP DATABASE drink_db;"
sudo mysql -e "CREATE DATABASE drink_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
sudo mysql drink_db < drink_db.sql
```