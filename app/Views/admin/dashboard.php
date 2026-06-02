<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-0">Dashboard</h1>
        <p class="text-muted mb-0">Real-time overview of properties, leads, agents and bookings.</p>
    </div>
    <a class="btn btn-primary" href="<?= e(url('/admin/properties/create')) ?>">Add Property</a>
</div>
<div class="row g-4 mb-4">
    <?php foreach ($stats as $label => $value): ?>
        <div class="col-md-3"><div class="admin-card bg-white p-4"><div class="metric text-primary"><?= e($value) ?></div><div class="text-muted"><?= e($label) ?></div></div></div>
    <?php endforeach; ?>
</div>
<div class="row g-4">
    <div class="col-lg-7">
        <div class="table-card">
            <div class="p-3 border-bottom"><h5 class="mb-0">Latest Leads</h5></div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Name</th><th>Mobile</th><th>Status</th><th>Source</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><?= e($lead['customer_name']) ?></td>
                            <td><?= e($lead['mobile']) ?></td>
                            <td><span class="badge bg-info"><?= e($lead['lead_status']) ?></span></td>
                            <td><?= e($lead['lead_source']) ?></td>
                            <td><a class="btn btn-sm btn-outline-primary" href="<?= e(url('/admin/leads/' . $lead['id'])) ?>">Open</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="table-card">
            <div class="p-3 border-bottom"><h5 class="mb-0">Recent Bookings</h5></div>
            <div class="list-group list-group-flush">
                <?php foreach ($bookings as $booking): ?>
                    <a class="list-group-item list-group-item-action" href="<?= e(url('/admin/bookings')) ?>">
                        <strong><?= e($booking['title']) ?></strong><br>
                        <span class="text-muted small"><?= money($booking['booking_amount']) ?> · <?= e($booking['booking_status']) ?></span>
                    </a>
                <?php endforeach; ?>
                <?php if (!$bookings): ?><div class="p-3 text-muted">No bookings yet.</div><?php endif; ?>
            </div>
        </div>
    </div>
</div>
