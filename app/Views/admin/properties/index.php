<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Properties</h1>
    <a class="btn btn-primary" href="<?= e(url('/admin/properties/create')) ?>">Add Property</a>
</div>
<div class="table-card table-responsive">
    <table class="table table-hover mb-0">
        <thead><tr><th>Title</th><th>City</th><th>Type</th><th>Price</th><th>Status</th><th width="220">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($properties as $property): ?>
            <tr>
                <td><?= e($property['title']) ?></td>
                <td><?= e($property['city']) ?></td>
                <td><?= e($property['property_type']) ?></td>
                <td><?= money($property['price']) ?></td>
                <td><span class="badge bg-success"><?= e($property['status']) ?></span></td>
                <td>
                    <a class="btn btn-sm btn-outline-secondary" href="<?= e(url('/properties/' . $property['slug'])) ?>" target="_blank">View</a>
                    <a class="btn btn-sm btn-outline-primary" href="<?= e(url('/admin/properties/' . $property['id'] . '/edit')) ?>">Edit</a>
                    <form class="d-inline" method="post" action="<?= e(url('/admin/properties/' . $property['id'] . '/delete')) ?>">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-outline-danger" data-confirm="Delete this property?">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
