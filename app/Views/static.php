<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="fw-bold"><?= e($heading) ?></h1>
                <p class="lead text-muted"><?= e($body) ?></p>
                <?php if (($showForm ?? false) === true): ?>
                    <form class="form-section" method="post" action="<?= e(url('/contact')) ?>">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="customer_name" required></div>
                            <div class="col-md-6"><label class="form-label">Mobile</label><input class="form-control" name="mobile" required></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email"></div>
                            <div class="col-md-6"><label class="form-label">City</label><input class="form-control" name="city"></div>
                            <div class="col-12"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="4" required>I want property consultation.</textarea></div>
                            <div class="col-12"><button class="btn btn-primary">Submit Enquiry</button></div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
