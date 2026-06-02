<div class="col-md-6 col-lg-4">
    <div class="card property-card">
        <img class="property-image" src="<?= e($property['featured_image'] ?: 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=900&q=80') ?>" alt="<?= e($property['title']) ?>">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <span class="badge badge-soft"><?= e($property['property_type']) ?></span>
                <span class="badge bg-success"><?= e($property['status']) ?></span>
            </div>
            <h5 class="card-title"><?= e($property['title']) ?></h5>
            <p class="text-muted mb-2"><?= e($property['location']) ?>, <?= e($property['city']) ?></p>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="text-primary"><?= money($property['price']) ?></strong>
                <span class="small text-muted"><?= e($property['bhk'] ?: '-') ?> BHK · <?= e($property['carpet_area'] ?: '-') ?> sq.ft</span>
            </div>
        </div>
        <div class="card-footer bg-white border-0 pt-0 pb-3 px-3 d-flex gap-2">
            <a class="btn btn-primary flex-fill" href="<?= e(url('/properties/' . $property['slug'])) ?>">View Details</a>
            <a class="btn btn-success" href="https://wa.me/<?= e(config('integrations.whatsapp_business_number')) ?>?text=I%20am%20interested%20in%20<?= rawurlencode($property['title']) ?>" target="_blank" rel="noopener">WhatsApp</a>
        </div>
    </div>
</div>
