<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Bookings</h1>
    <span class="text-muted">Reservation and payment tracking.</span>
</div>
<div class="table-card table-responsive">
    <table class="table table-hover mb-0">
        <thead><tr><th>Property</th><th>Customer</th><th>Mobile</th><th>Amount</th><th>Payment</th><th>Status</th><th>Created</th></tr></thead>
        <tbody><?php foreach ($bookings as $booking): ?><tr>
            <td><?= e($booking['title']) ?></td><td><?= e($booking['customer_name']) ?></td><td><?= e($booking['mobile']) ?></td><td><?= money($booking['booking_amount']) ?></td><td><?= e($booking['payment_status']) ?></td><td><?= e($booking['booking_status']) ?></td><td><?= e($booking['created_at']) ?></td>
        </tr><?php endforeach; ?></tbody>
    </table>
</div>
