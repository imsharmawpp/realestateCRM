<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? config('app.name')) ?></title>
    <meta name="description" content="Hostinger-ready PHP real estate portal with CRM, leads, bookings and automation workflows.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('/public/assets/css/app.css')) ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="<?= e(url('/')) ?>"><?= e(config('app.name')) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/properties')) ?>">Properties</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/about')) ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= e(url('/contact')) ?>">Contact</a></li>
                <?php if (current_user()): ?>
                    <li class="nav-item"><a class="btn btn-outline-primary btn-sm" href="<?= e(url('/admin')) ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm" href="<?= e(url('/admin/logout')) ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-primary btn-sm" href="<?= e(url('/admin/login')) ?>">Admin Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?php foreach (['success', 'warning', 'error'] as $flashType): ?>
        <?php if ($message = flash($flashType)): ?>
            <div class="container mt-3">
                <div class="alert alert-<?= $flashType === 'error' ? 'danger' : e($flashType) ?> alert-dismissible fade show" role="alert">
                    <?= e($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= $content ?>
</main>

<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <h5><?= e(config('app.name')) ?></h5>
                <p class="text-white-50 mb-0">Indian real estate portal with CRM, WhatsApp automation, lead tracking, bookings and agent management.</p>
            </div>
            <div class="col-md-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50" href="<?= e(url('/properties')) ?>">Find Properties</a></li>
                    <li><a class="text-white-50" href="<?= e(url('/contact')) ?>">Request Callback</a></li>
                    <li><a class="text-white-50" href="<?= e(url('/admin')) ?>">CRM Dashboard</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Automation Ready</h6>
                <p class="text-white-50 small mb-0">Connect SMTP, WhatsApp Business API providers and Razorpay from Hostinger environment settings.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url('/public/assets/js/app.js')) ?>"></script>
</body>
</html>
