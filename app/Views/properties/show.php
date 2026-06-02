<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <img class="img-fluid rounded-4 shadow-sm mb-4 w-100" style="max-height:520px;object-fit:cover" src="<?= e($property['featured_image'] ?: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=80') ?>" alt="<?= e($property['title']) ?>">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-primary"><?= e($property['property_type']) ?></span>
                    <span class="badge bg-success"><?= e($property['status']) ?></span>
                    <span class="badge bg-secondary"><?= e($property['construction_status']) ?></span>
                </div>
                <h1 class="fw-bold"><?= e($property['title']) ?></h1>
                <p class="lead text-muted"><?= e($property['location']) ?>, <?= e($property['city']) ?>, <?= e($property['state']) ?></p>
                <h2 class="text-primary fw-bold"><?= money($property['price']) ?></h2>
                <hr>
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3"><div class="p-3 bg-light rounded"><strong><?= e($property['bhk']) ?></strong><br><small>BHK</small></div></div>
                    <div class="col-6 col-md-3"><div class="p-3 bg-light rounded"><strong><?= e($property['carpet_area']) ?></strong><br><small>Carpet sq.ft</small></div></div>
                    <div class="col-6 col-md-3"><div class="p-3 bg-light rounded"><strong><?= e($property['furnishing_status']) ?></strong><br><small>Furnishing</small></div></div>
                    <div class="col-6 col-md-3"><div class="p-3 bg-light rounded"><strong><?= e($property['possession_date'] ?: 'Ready') ?></strong><br><small>Possession</small></div></div>
                </div>
                <h4>Description</h4>
                <p><?= nl2br(e($property['description'])) ?></p>
                <?php if ($property['amenities']): ?>
                    <h4>Amenities</h4>
                    <p><?= e($property['amenities']) ?></p>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <div class="form-section sticky-top" style="top:90px">
                    <h4 class="fw-bold">Enquire Now</h4>
                    <p class="text-muted">This creates a CRM lead and notifies your team.</p>
                    <form method="post" action="<?= e(url('/properties/' . $property['slug'] . '/enquire')) ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="customer_name" required></div>
                        <div class="mb-3"><label class="form-label">Mobile</label><input class="form-control" name="mobile" required></div>
                        <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email"></div>
                        <div class="mb-3"><label class="form-label">Requirement</label><textarea class="form-control" name="message" rows="3">I am interested in <?= e($property['title']) ?>.</textarea></div>
                        <button class="btn btn-primary w-100 mb-2">Send Enquiry</button>
                    </form>
                    <form method="post" action="<?= e(url('/properties/' . $property['slug'] . '/book')) ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="customer_name" value="Website Customer">
                        <input type="hidden" name="mobile" value="0000000000">
                        <button class="btn btn-outline-success w-100">Reserve / Book Property</button>
                    </form>
                    <a class="btn btn-success w-100 mt-2" target="_blank" rel="noopener" href="https://wa.me/<?= e(config('integrations.whatsapp_business_number')) ?>?text=I%20want%20details%20for%20<?= rawurlencode($property['title']) ?>">WhatsApp Agent</a>
                </div>
            </div>
        </div>
    </div>
</section>
