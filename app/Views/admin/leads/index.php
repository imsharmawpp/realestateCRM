<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Leads</h1>
    <span class="text-muted">Track enquiries from website, WhatsApp and campaigns.</span>
</div>
<div class="table-card table-responsive">
    <table class="table table-hover mb-0">
        <thead><tr><th>Name</th><th>Mobile</th><th>Property</th><th>Agent</th><th>Status</th><th>Source</th><th>Next Follow-up</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($leads as $lead): ?>
            <tr>
                <td><?= e($lead['customer_name']) ?></td>
                <td><?= e($lead['mobile']) ?></td>
                <td><?= e($lead['property_title'] ?? 'General') ?></td>
                <td><?= e($lead['agent_name'] ?? 'Unassigned') ?></td>
                <td><span class="badge bg-info"><?= e($lead['lead_status']) ?></span></td>
                <td><?= e($lead['lead_source']) ?></td>
                <td><?= e($lead['next_follow_up_at'] ?? '-') ?></td>
                <td><a class="btn btn-sm btn-primary" href="<?= e(url('/admin/leads/' . $lead['id'])) ?>">Open</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
