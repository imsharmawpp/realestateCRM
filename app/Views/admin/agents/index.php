<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Agents</h1>
    <a class="btn btn-primary" href="<?= e(url('/admin/agents/create')) ?>">Add Agent</a>
</div>
<div class="table-card table-responsive">
    <table class="table table-hover mb-0">
        <thead><tr><th>Name</th><th>Mobile</th><th>Email</th><th>City</th><th>Commission</th><th>Status</th><th></th></tr></thead>
        <tbody><?php foreach ($agents as $agent): ?><tr>
            <td><?= e($agent['agent_name']) ?></td><td><?= e($agent['mobile']) ?></td><td><?= e($agent['email']) ?></td><td><?= e($agent['service_city']) ?></td><td><?= e($agent['commission_rate']) ?>%</td><td><?= e($agent['status']) ?></td>
            <td><a class="btn btn-sm btn-outline-primary" href="<?= e(url('/admin/agents/' . $agent['id'] . '/edit')) ?>">Edit</a></td>
        </tr><?php endforeach; ?></tbody>
    </table>
</div>
