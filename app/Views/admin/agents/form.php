<h1 class="h3 fw-bold mb-4"><?= e($heading) ?></h1>
<form class="form-section" method="post" action="<?= e($action) ?>">
    <?= csrf_field() ?>
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Agent Name</label><input class="form-control" name="agent_name" value="<?= e($agent['agent_name'] ?? '') ?>" required></div>
        <div class="col-md-3"><label class="form-label">Mobile</label><input class="form-control" name="mobile" value="<?= e($agent['mobile'] ?? '') ?>" required></div>
        <div class="col-md-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="<?= e($agent['email'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">License Number</label><input class="form-control" name="license_number" value="<?= e($agent['license_number'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Commission %</label><input class="form-control" type="number" step="0.01" name="commission_rate" value="<?= e($agent['commission_rate'] ?? '1.50') ?>"></div>
        <div class="col-md-4"><label class="form-label">Service City</label><input class="form-control" name="service_city" value="<?= e($agent['service_city'] ?? '') ?>"></div>
        <div class="col-12"><button class="btn btn-primary">Save Agent</button> <a class="btn btn-outline-secondary" href="<?= e(url('/admin/agents')) ?>">Cancel</a></div>
    </div>
</form>
