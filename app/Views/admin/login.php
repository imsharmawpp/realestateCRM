<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="form-section">
                    <h1 class="h3 fw-bold mb-3">Admin Login</h1>
                    <p class="text-muted">Use the seeded admin account after importing `database/seed.sql`.</p>
                    <form method="post" action="<?= e(url('/admin/login')) ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="admin@example.com" required></div>
                        <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" placeholder="Admin@12345" required></div>
                        <button class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
