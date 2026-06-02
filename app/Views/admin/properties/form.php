<h1 class="h3 fw-bold mb-4"><?= e($heading) ?></h1>
<form class="form-section" method="post" enctype="multipart/form-data" action="<?= e($action) ?>">
    <?= csrf_field() ?>
    <div class="row g-3">
        <div class="col-md-8"><label class="form-label">Title</label><input class="form-control" name="title" value="<?= e($property['title'] ?? '') ?>" required></div>
        <div class="col-md-4"><label class="form-label">Status</label><select class="form-select" name="status"><option>Available</option><option>Reserved</option><option>Sold</option><option>Rented</option><option>Inactive</option></select></div>
        <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="5" required><?= e($property['description'] ?? '') ?></textarea></div>
        <div class="col-md-3"><label class="form-label">Price</label><input class="form-control" type="number" name="price" value="<?= e($property['price'] ?? '') ?>" required></div>
        <div class="col-md-3"><label class="form-label">Type</label><input class="form-control" name="property_type" value="<?= e($property['property_type'] ?? 'Apartment') ?>" required></div>
        <div class="col-md-3"><label class="form-label">BHK</label><input class="form-control" type="number" name="bhk" value="<?= e($property['bhk'] ?? '') ?>"></div>
        <div class="col-md-3"><label class="form-label">Carpet Area</label><input class="form-control" type="number" name="carpet_area" value="<?= e($property['carpet_area'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Location</label><input class="form-control" name="location" value="<?= e($property['location'] ?? '') ?>" required></div>
        <div class="col-md-3"><label class="form-label">City</label><input class="form-control" name="city" value="<?= e($property['city'] ?? '') ?>" required></div>
        <div class="col-md-3"><label class="form-label">State</label><input class="form-control" name="state" value="<?= e($property['state'] ?? '') ?>" required></div>
        <div class="col-md-2"><label class="form-label">Pincode</label><input class="form-control" name="pincode" value="<?= e($property['pincode'] ?? '') ?>"></div>
        <div class="col-md-4"><label class="form-label">Furnishing</label><input class="form-control" name="furnishing_status" value="<?= e($property['furnishing_status'] ?? 'Semi Furnished') ?>"></div>
        <div class="col-md-4"><label class="form-label">Construction</label><input class="form-control" name="construction_status" value="<?= e($property['construction_status'] ?? 'Ready To Move') ?>"></div>
        <div class="col-md-4"><label class="form-label">Possession Date</label><input class="form-control" type="date" name="possession_date" value="<?= e($property['possession_date'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Featured Image URL</label><input class="form-control" name="featured_image" value="<?= e($property['featured_image'] ?? '') ?>"></div>
        <div class="col-md-6"><label class="form-label">Or Upload Image</label><input class="form-control" type="file" name="featured_upload" accept=".jpg,.jpeg,.png,.webp"></div>
        <div class="col-12"><label class="form-label">Amenities</label><textarea class="form-control" name="amenities" rows="2"><?= e($property['amenities'] ?? '') ?></textarea></div>
        <div class="col-12"><button class="btn btn-primary">Save Property</button> <a class="btn btn-outline-secondary" href="<?= e(url('/admin/properties')) ?>">Cancel</a></div>
    </div>
</form>
<script>
document.querySelector('[name="status"]').value = <?= json_encode($property['status'] ?? 'Available') ?>;
</script>
