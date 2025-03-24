<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'XING FU CHA'; ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <?php require __DIR__ . '/header.php'; ?>
    
    <main class="<?php echo isset($pageClass) ? $pageClass : ''; ?>">
        <?php echo $content; ?>
    </main>
    
    <?php require __DIR__ . '/footer.php'; ?>
    
    <script src="/assets/js/main.js"></script>
    <?php if (isset($pageScript)): ?>
    <script src="<?php echo $pageScript; ?>"></script>
    <?php endif; ?>
</body>
</html>

