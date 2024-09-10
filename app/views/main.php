<!doctype html>
<html lang="en" class="h-100" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Yaroslav Sytnyk">
    <title>CRM Module</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />

    <meta name="theme-color" content="#712cf9">

</head>
<body class="d-flex flex-column h-100">
<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">
        <?php require_once ($type === 'add') ? __DIR__ . '/add_user.php' : __DIR__ . '/show_user.php'; ?>
    </div>
</main>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
