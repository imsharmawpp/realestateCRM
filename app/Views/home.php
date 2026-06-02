<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="badge bg-success mb-3">Hostinger-ready PHP/MySQL CRM</span>
                <h1 class="display-4 fw-bold mb-3">Find, manage and close real estate leads faster.</h1>
                <p class="lead mb-4">A complete Indian real estate portal with property listings, enquiries, agent tracking, CRM follow-ups, bookings and automation-ready workflows.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="btn btn-light btn-lg" href="<?= e(url('/properties')) ?>">Explore Properties</a>
                    <a class="btn btn-outline-light btn-lg" href="<?= e(url('/contact')) ?>">Request Callback</a>
                </div>
            </div>
            <div class="col-lg-5">
                <form class="card search-card p-4 text-dark" method="get" action="<?= e(url('/properties')) ?>">
                    <h5 class="fw-bold mb-3">Search Properties</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input class="form-control" name="city" placeholder="Mumbai, Pune">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="property_type">
                                <option value="">Any</option>
                                <option>Apartment</option>
                                <option>Villa</option>
                                <option>Plot</option>
                                <option>Commercial</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Min Budget</label>
                            <input class="form-control" type="number" name="min_price" placeholder="2500000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Max Budget</label>
                            <input class="form-control" type="number" name="max_price" placeholder="15000000">
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-4">Search Now</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3"><div class="card stat-card p-4"><div class="metric text-primary"><?= (int) $stats['properties'] ?></div><div>Properties</div></div></div>
            <div class="col-md-3"><div class="card stat-card p-4"><div class="metric text-primary"><?= (int) $stats['leads'] ?></div><div>Leads Captured</div></div></div>
            <div class="col-md-3"><div class="card stat-card p-4"><div class="metric text-primary"><?= (int) $stats['agents'] ?></div><div>Agents</div></div></div>
            <div class="col-md-3"><div class="card stat-card p-4"><div class="metric text-primary"><?= (int) $stats['bookings'] ?></div><div>Bookings</div></div></div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Featured Properties</h2>
                <p class="text-muted mb-0">Ready-to-test public listings connected to the CRM.</p>
            </div>
            <a class="btn btn-outline-primary" href="<?= e(url('/properties')) ?>">View All</a>
        </div>
        <div class="row g-4">
            <?php foreach ($properties as $property): ?>
                <?php require BASE_PATH . '/app/Views/partials/property_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="cta-strip p-4 p-md-5 d-md-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold">Need a site visit or project consultation?</h2>
                <p class="mb-md-0 text-white-50">Submit your enquiry and the CRM will create a lead for agent follow-up.</p>
            </div>
            <a class="btn btn-success btn-lg" href="<?= e(url('/contact')) ?>">Create Enquiry</a>
        </div>
    </div>
</section>
