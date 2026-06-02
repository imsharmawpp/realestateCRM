<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Admin Dashboard') ?> · <?= e(config('app.name')) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('/public/assets/css/app.css')) ?>">
</head>
<body class="admin-bg">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="<?= e(url('/admin')) ?>">CRM Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/admin/properties')) ?>">Properties</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/admin/leads')) ?>">Leads</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/admin/agents')) ?>">Agents</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/admin/bookings')) ?>">Bookings</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/')) ?>" target="_blank">Website</a></li>
            </ul>
            <span class="navbar-text me-3"><?= e(current_user()['name'] ?? '') ?></span>
            <a class="btn btn-light btn-sm" href="<?= e(url('/admin/logout')) ?>">Logout</a>
        </div>
    </div>
</nav>

<main class="container-fluid py-4">
    <?php foreach (['success', 'warning', 'error'] as $flashType): ?>
        <?php if ($message = flash($flashType)): ?>
            <div class="alert alert-<?= $flashType === 'error' ? 'danger' : e($flashType) ?> alert-dismissible fade show" role="alert">
                <?= e($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= $content ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url('/public/assets/js/app.js')) ?>"></script>
</body>
</html>
