<div class="row g-4">
    <div class="col-lg-5">
        <div class="form-section">
            <h1 class="h4 fw-bold">Lead: <?= e($lead['customer_name']) ?></h1>
            <p class="text-muted mb-4"><?= e($lead['mobile']) ?> · <?= e($lead['email']) ?></p>
            <form method="post" action="<?= e(url('/admin/leads/' . $lead['id'] . '/update')) ?>">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="lead_status">
                    <?php foreach (['New Lead','Contacted','Follow Up','Site Visit','Negotiation','Booked','Closed','Lost'] as $status): ?>
                        <option <?= $lead['lead_status'] === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                    <?php endforeach; ?>
                </select></div>
                <div class="mb-3"><label class="form-label">Assign Agent</label><select class="form-select" name="assigned_agent_id"><option value="">Unassigned</option><?php foreach ($agents as $agent): ?><option value="<?= e($agent['id']) ?>" <?= (int)($lead['assigned_agent_id'] ?? 0) === (int)$agent['id'] ? 'selected' : '' ?>><?= e($agent['agent_name']) ?></option><?php endforeach; ?></select></div>
                <div class="mb-3"><label class="form-label">Next Follow-up</label><input class="form-control" type="datetime-local" name="next_follow_up_at" value="<?= e($lead['next_follow_up_at'] ? str_replace(' ', 'T', substr($lead['next_follow_up_at'], 0, 16)) : '') ?>"></div>
                <button class="btn btn-primary">Update Lead</button>
            </form>
        </div>
        <div class="form-section mt-4">
            <h2 class="h5 fw-bold">Add CRM Activity</h2>
            <form method="post" action="<?= e(url('/admin/leads/' . $lead['id'] . '/activity')) ?>">
                <?= csrf_field() ?>
                <div class="mb-3"><label class="form-label">Activity Type</label><select class="form-select" name="activity_type"><option>Call</option><option>WhatsApp</option><option>Email</option><option>Site Visit</option><option>Note</option></select></div>
                <div class="mb-3"><label class="form-label">Remarks</label><textarea class="form-control" name="remarks" rows="3" required></textarea></div>
                <div class="mb-3"><label class="form-label">Next Follow-up</label><input class="form-control" type="datetime-local" name="next_follow_up_at"></div>
                <button class="btn btn-success">Add Activity</button>
            </form>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="form-section">
            <h2 class="h5 fw-bold">Activity Timeline</h2>
            <div class="timeline mt-4">
                <?php foreach ($activities as $activity): ?>
                    <div class="timeline-item">
                        <strong><?= e($activity['activity_type']) ?></strong>
                        <span class="text-muted small">· <?= e($activity['created_at']) ?></span>
                        <p class="mb-1"><?= nl2br(e($activity['remarks'])) ?></p>
                        <?php if ($activity['next_follow_up_at']): ?><small class="text-primary">Next: <?= e($activity['next_follow_up_at']) ?></small><?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php if (!$activities): ?><p class="text-muted">No activities yet.</p><?php endif; ?>
            </div>
        </div>
    </div>
</div>
