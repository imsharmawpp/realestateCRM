<section class="py-5 bg-light">
    <div class="container">
        <h1 class="fw-bold">Properties</h1>
        <p class="text-muted">Search by city, property type, BHK, price range and status.</p>
        <form class="card search-card p-3 mb-4" method="get">
            <div class="row g-3 align-items-end">
                <div class="col-md-3"><label class="form-label">City</label><input class="form-control" name="city" value="<?= e($_GET['city'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Type</label><input class="form-control" name="property_type" value="<?= e($_GET['property_type'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">BHK</label><input class="form-control" name="bhk" value="<?= e($_GET['bhk'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Min Price</label><input class="form-control" type="number" name="min_price" value="<?= e($_GET['min_price'] ?? '') ?>"></div>
                <div class="col-md-2"><label class="form-label">Max Price</label><input class="form-control" type="number" name="max_price" value="<?= e($_GET['max_price'] ?? '') ?>"></div>
                <div class="col-md-1"><button class="btn btn-primary w-100">Go</button></div>
            </div>
        </form>
        <div class="row g-4">
            <?php if (!$properties): ?>
                <div class="col-12"><div class="alert alert-info">No properties found. Try different filters.</div></div>
            <?php endif; ?>
            <?php foreach ($properties as $property): ?>
                <?php require BASE_PATH . '/app/Views/partials/property_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
