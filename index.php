<?php

declare(strict_types=1);

require __DIR__ . '/app/bootstrap.php';

try {
    dispatch();
} catch (Throwable $exception) {
    handle_exception($exception);
}

function dispatch(): void
{
    $path = path();
    $method = method();

    if ($method !== 'GET') {
        verify_csrf();
    }

    if ($path === '/' && $method === 'GET') {
        show_home();
        return;
    }

    if ($path === '/about' && $method === 'GET') {
        view('static', [
            'title' => 'About Us',
            'heading' => 'About Our Real Estate CRM Portal',
            'body' => 'We help real estate teams capture enquiries, manage agents, track follow-ups, publish properties and convert bookings from one Hostinger-compatible PHP application.',
        ]);
        return;
    }

    if ($path === '/contact') {
        if ($method === 'GET') {
            view('static', [
                'title' => 'Contact',
                'heading' => 'Request a Callback',
                'body' => 'Submit your property requirement and our CRM will create a lead for follow-up.',
                'showForm' => true,
            ]);
            return;
        }
        create_general_lead();
        return;
    }

    if ($path === '/properties' && $method === 'GET') {
        list_properties();
        return;
    }

    if (preg_match('#^/properties/([a-z0-9-]+)$#', $path, $matches) && $method === 'GET') {
        show_property($matches[1]);
        return;
    }

    if (preg_match('#^/properties/([a-z0-9-]+)/enquire$#', $path, $matches) && $method === 'POST') {
        create_property_lead($matches[1]);
        return;
    }

    if (preg_match('#^/properties/([a-z0-9-]+)/book$#', $path, $matches) && $method === 'POST') {
        create_booking($matches[1]);
        return;
    }

    if ($path === '/admin/login') {
        if ($method === 'GET') {
            view('admin/login', ['title' => 'Admin Login']);
            return;
        }
        login_admin();
        return;
    }

    if ($path === '/admin/logout' && $method === 'GET') {
        session_destroy();
        redirect('/');
    }

    if ($path === '/admin' && $method === 'GET') {
        admin_dashboard();
        return;
    }

    if ($path === '/admin/properties' && $method === 'GET') {
        admin_properties();
        return;
    }

    if ($path === '/admin/properties/create') {
        if ($method === 'GET') {
            admin_property_form();
            return;
        }
        admin_store_property();
        return;
    }

    if (preg_match('#^/admin/properties/(\d+)/edit$#', $path, $matches)) {
        if ($method === 'GET') {
            admin_property_form((int) $matches[1]);
            return;
        }
        admin_update_property((int) $matches[1]);
        return;
    }

    if (preg_match('#^/admin/properties/(\d+)/delete$#', $path, $matches) && $method === 'POST') {
        require_admin();
        db_exec('DELETE FROM properties WHERE id = ?', [(int) $matches[1]]);
        flash('success', 'Property deleted.');
        redirect('/admin/properties');
    }

    if ($path === '/admin/leads' && $method === 'GET') {
        admin_leads();
        return;
    }

    if (preg_match('#^/admin/leads/(\d+)$#', $path, $matches) && $method === 'GET') {
        admin_show_lead((int) $matches[1]);
        return;
    }

    if (preg_match('#^/admin/leads/(\d+)/update$#', $path, $matches) && $method === 'POST') {
        admin_update_lead((int) $matches[1]);
        return;
    }

    if (preg_match('#^/admin/leads/(\d+)/activity$#', $path, $matches) && $method === 'POST') {
        admin_add_activity((int) $matches[1]);
        return;
    }

    if ($path === '/admin/agents' && $method === 'GET') {
        admin_agents();
        return;
    }

    if ($path === '/admin/agents/create') {
        if ($method === 'GET') {
            admin_agent_form();
            return;
        }
        admin_store_agent();
        return;
    }

    if (preg_match('#^/admin/agents/(\d+)/edit$#', $path, $matches)) {
        if ($method === 'GET') {
            admin_agent_form((int) $matches[1]);
            return;
        }
        admin_update_agent((int) $matches[1]);
        return;
    }

    if ($path === '/admin/bookings' && $method === 'GET') {
        admin_bookings();
        return;
    }

    if ($path === '/api/properties' && $method === 'GET') {
        json_response(['success' => true, 'data' => property_query()]);
    }

    if ($path === '/api/leads' && $method === 'GET') {
        require_admin();
        json_response(['success' => true, 'data' => db_all('SELECT * FROM leads ORDER BY id DESC LIMIT 100')]);
    }

    http_response_code(404);
    view('static', [
        'title' => 'Page Not Found',
        'heading' => '404 - Page Not Found',
        'body' => 'The requested page could not be found.',
    ]);
}

function show_home(): void
{
    $stats = [
        'properties' => db_one('SELECT COUNT(*) AS total FROM properties')['total'] ?? 0,
        'leads' => db_one('SELECT COUNT(*) AS total FROM leads')['total'] ?? 0,
        'agents' => db_one('SELECT COUNT(*) AS total FROM agents')['total'] ?? 0,
        'bookings' => db_one('SELECT COUNT(*) AS total FROM bookings')['total'] ?? 0,
    ];
    $properties = db_all('SELECT * FROM properties WHERE status IN ("Available", "Reserved") ORDER BY id DESC LIMIT 6');
    view('home', ['title' => 'Home', 'stats' => $stats, 'properties' => $properties]);
}

function property_query(): array
{
    $sql = 'SELECT * FROM properties WHERE status != "Inactive"';
    $params = [];
    foreach (['city', 'property_type', 'bhk'] as $field) {
        if (!empty($_GET[$field])) {
            $sql .= " AND {$field} LIKE ?";
            $params[] = '%' . $_GET[$field] . '%';
        }
    }
    if (!empty($_GET['min_price'])) {
        $sql .= ' AND price >= ?';
        $params[] = (float) $_GET['min_price'];
    }
    if (!empty($_GET['max_price'])) {
        $sql .= ' AND price <= ?';
        $params[] = (float) $_GET['max_price'];
    }
    $sql .= ' ORDER BY id DESC LIMIT 60';
    return db_all($sql, $params);
}

function list_properties(): void
{
    view('properties/index', ['title' => 'Properties', 'properties' => property_query()]);
}

function show_property(string $slug): void
{
    $property = db_one('SELECT * FROM properties WHERE slug = ? LIMIT 1', [$slug]);
    if (!$property) {
        http_response_code(404);
        view('static', ['title' => 'Property Not Found', 'heading' => 'Property Not Found', 'body' => 'This property is not available.']);
        return;
    }
    view('properties/show', ['title' => $property['title'], 'property' => $property]);
}

function create_general_lead(): void
{
    $propertyId = null;
    $message = trim($_POST['message'] ?? 'General property enquiry');
    insert_lead($propertyId, 'Website Contact', $message);
    flash('success', 'Thank you. Your enquiry has been captured in the CRM.');
    redirect('/contact');
}

function create_property_lead(string $slug): void
{
    $property = db_one('SELECT * FROM properties WHERE slug = ? LIMIT 1', [$slug]);
    if (!$property) {
        flash('error', 'Property not found.');
        redirect('/properties');
    }
    insert_lead((int) $property['id'], 'Property Enquiry', trim($_POST['message'] ?? 'Property enquiry'));
    flash('success', 'Enquiry submitted. Our agent will contact you shortly.');
    redirect('/properties/' . $slug);
}

function insert_lead(?int $propertyId, string $source, string $message): int
{
    $agentId = auto_assign_agent($_POST['city'] ?? null);
    db_exec('INSERT INTO leads (customer_name, mobile, email, property_id, assigned_agent_id, lead_source, lead_score, lead_status, message, next_follow_up_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL 1 DAY), NOW(), NOW())', [
        trim($_POST['customer_name'] ?? 'Website Customer'),
        trim($_POST['mobile'] ?? ''),
        trim($_POST['email'] ?? ''),
        $propertyId,
        $agentId,
        $source,
        $propertyId ? 75 : 50,
        'New Lead',
        $message,
    ]);
    $leadId = (int) db()->lastInsertId();
    db_exec('INSERT INTO crm_activities (lead_id, agent_id, activity_type, remarks, next_follow_up_at, created_at) VALUES (?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL 1 DAY), NOW())', [$leadId, $agentId, 'Lead Created', $message]);
    db_exec('INSERT INTO automation_logs (lead_id, channel, template_name, recipient, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [$leadId, 'whatsapp', 'lead_received', trim($_POST['mobile'] ?? ''), 'queued']);
    if (!empty($_POST['email'])) {
        db_exec('INSERT INTO automation_logs (lead_id, channel, template_name, recipient, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [$leadId, 'email', 'lead_received', trim($_POST['email']), 'queued']);
    }
    return $leadId;
}

function auto_assign_agent(?string $city): ?int
{
    if ($city) {
        $agent = db_one('SELECT id FROM agents WHERE status = "active" AND service_city LIKE ? ORDER BY id ASC LIMIT 1', ['%' . $city . '%']);
        if ($agent) {
            return (int) $agent['id'];
        }
    }
    $agent = db_one('SELECT id FROM agents WHERE status = "active" ORDER BY id ASC LIMIT 1');
    return $agent ? (int) $agent['id'] : null;
}

function create_booking(string $slug): void
{
    $property = db_one('SELECT * FROM properties WHERE slug = ? LIMIT 1', [$slug]);
    if (!$property) {
        flash('error', 'Property not found.');
        redirect('/properties');
    }
    db_exec('INSERT INTO bookings (property_id, customer_name, mobile, booking_amount, total_amount, payment_status, booking_status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
        $property['id'],
        trim($_POST['customer_name'] ?? 'Website Customer'),
        trim($_POST['mobile'] ?? '0000000000'),
        51000,
        $property['price'],
        'Pending',
        'Pending Payment',
    ]);
    $bookingId = (int) db()->lastInsertId();
    db_exec('UPDATE properties SET status = "Reserved", updated_at = NOW() WHERE id = ?', [$property['id']]);
    db_exec('INSERT INTO automation_logs (booking_id, channel, template_name, recipient, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [$bookingId, 'whatsapp', 'booking_pending_payment', trim($_POST['mobile'] ?? '0000000000'), 'queued']);
    flash('success', 'Booking reservation created. Complete payment integration from admin/payment settings.');
    redirect('/properties/' . $slug);
}

function login_admin(): void
{
    $email = trim($_POST['email'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $user = db_one('SELECT * FROM users WHERE email = ? AND status = "active" LIMIT 1', [$email]);
    if (!$user || !password_verify($password, $user['password_hash'])) {
        flash('error', 'Invalid email or password.');
        redirect('/admin/login');
    }
    $_SESSION['user_id'] = $user['id'];
    flash('success', 'Welcome back, ' . $user['name'] . '.');
    redirect('/admin');
}

function admin_dashboard(): void
{
    require_admin();
    $stats = [
        'Properties' => db_one('SELECT COUNT(*) AS total FROM properties')['total'] ?? 0,
        'Leads' => db_one('SELECT COUNT(*) AS total FROM leads')['total'] ?? 0,
        'Agents' => db_one('SELECT COUNT(*) AS total FROM agents')['total'] ?? 0,
        'Bookings' => db_one('SELECT COUNT(*) AS total FROM bookings')['total'] ?? 0,
    ];
    $leads = db_all('SELECT * FROM leads ORDER BY id DESC LIMIT 8');
    $bookings = db_all('SELECT b.*, p.title FROM bookings b JOIN properties p ON p.id = b.property_id ORDER BY b.id DESC LIMIT 6');
    view('admin/dashboard', compact('stats', 'leads', 'bookings'), 'admin');
}

function admin_properties(): void
{
    require_admin();
    $properties = db_all('SELECT * FROM properties ORDER BY id DESC');
    view('admin/properties/index', compact('properties'), 'admin');
}

function admin_property_form(?int $id = null): void
{
    require_admin();
    $property = $id ? db_one('SELECT * FROM properties WHERE id = ?', [$id]) : [];
    view('admin/properties/form', [
        'property' => $property,
        'heading' => $id ? 'Edit Property' : 'Add Property',
        'action' => $id ? url('/admin/properties/' . $id . '/edit') : url('/admin/properties/create'),
    ], 'admin');
}

function property_payload(?array $existing = null): array
{
    $title = trim($_POST['title'] ?? '');
    if ($title === '') {
        throw new RuntimeException('Property title is required.');
    }
    $image = trim($_POST['featured_image'] ?? ($existing['featured_image'] ?? ''));
    $uploaded = upload_file('featured_upload', ['jpg', 'jpeg', 'png', 'webp']);
    if ($uploaded) {
        $image = $uploaded;
    }
    return [
        'title' => $title,
        'slug' => $existing['slug'] ?? slugify($title),
        'description' => trim($_POST['description'] ?? ''),
        'price' => (float) ($_POST['price'] ?? 0),
        'location' => trim($_POST['location'] ?? ''),
        'city' => trim($_POST['city'] ?? ''),
        'state' => trim($_POST['state'] ?? ''),
        'pincode' => trim($_POST['pincode'] ?? ''),
        'property_type' => trim($_POST['property_type'] ?? 'Apartment'),
        'bhk' => $_POST['bhk'] !== '' ? (int) $_POST['bhk'] : null,
        'carpet_area' => $_POST['carpet_area'] !== '' ? (float) $_POST['carpet_area'] : null,
        'furnishing_status' => trim($_POST['furnishing_status'] ?? ''),
        'construction_status' => trim($_POST['construction_status'] ?? ''),
        'possession_date' => $_POST['possession_date'] ?: null,
        'status' => trim($_POST['status'] ?? 'Available'),
        'featured_image' => $image,
        'amenities' => trim($_POST['amenities'] ?? ''),
    ];
}

function admin_store_property(): void
{
    require_admin();
    $p = property_payload();
    db_exec('INSERT INTO properties (title, slug, description, price, location, city, state, pincode, property_type, bhk, carpet_area, furnishing_status, construction_status, possession_date, status, featured_image, amenities, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', array_values($p));
    flash('success', 'Property created.');
    redirect('/admin/properties');
}

function admin_update_property(int $id): void
{
    require_admin();
    $existing = db_one('SELECT * FROM properties WHERE id = ?', [$id]);
    if (!$existing) {
        flash('error', 'Property not found.');
        redirect('/admin/properties');
    }
    $p = property_payload($existing);
    db_exec('UPDATE properties SET title=?, slug=?, description=?, price=?, location=?, city=?, state=?, pincode=?, property_type=?, bhk=?, carpet_area=?, furnishing_status=?, construction_status=?, possession_date=?, status=?, featured_image=?, amenities=?, updated_at=NOW() WHERE id=?', [...array_values($p), $id]);
    flash('success', 'Property updated.');
    redirect('/admin/properties');
}

function admin_leads(): void
{
    require_admin();
    $leads = db_all('SELECT l.*, p.title AS property_title, a.agent_name FROM leads l LEFT JOIN properties p ON p.id = l.property_id LEFT JOIN agents a ON a.id = l.assigned_agent_id ORDER BY l.id DESC');
    view('admin/leads/index', compact('leads'), 'admin');
}

function admin_show_lead(int $id): void
{
    require_admin();
    $lead = db_one('SELECT * FROM leads WHERE id = ?', [$id]);
    if (!$lead) {
        flash('error', 'Lead not found.');
        redirect('/admin/leads');
    }
    $agents = db_all('SELECT * FROM agents WHERE status = "active" ORDER BY agent_name');
    $activities = db_all('SELECT * FROM crm_activities WHERE lead_id = ? ORDER BY id DESC', [$id]);
    view('admin/leads/show', compact('lead', 'agents', 'activities'), 'admin');
}

function admin_update_lead(int $id): void
{
    require_admin();
    $agentId = $_POST['assigned_agent_id'] !== '' ? (int) $_POST['assigned_agent_id'] : null;
    $followUp = $_POST['next_follow_up_at'] ? str_replace('T', ' ', $_POST['next_follow_up_at']) . ':00' : null;
    db_exec('UPDATE leads SET lead_status=?, assigned_agent_id=?, next_follow_up_at=?, updated_at=NOW() WHERE id=?', [$_POST['lead_status'], $agentId, $followUp, $id]);
    flash('success', 'Lead updated.');
    redirect('/admin/leads/' . $id);
}

function admin_add_activity(int $id): void
{
    require_admin();
    $lead = db_one('SELECT assigned_agent_id FROM leads WHERE id = ?', [$id]);
    $followUp = $_POST['next_follow_up_at'] ? str_replace('T', ' ', $_POST['next_follow_up_at']) . ':00' : null;
    db_exec('INSERT INTO crm_activities (lead_id, agent_id, activity_type, remarks, next_follow_up_at, created_at) VALUES (?, ?, ?, ?, ?, NOW())', [$id, $lead['assigned_agent_id'] ?? null, $_POST['activity_type'], trim($_POST['remarks']), $followUp]);
    if ($followUp) {
        db_exec('UPDATE leads SET next_follow_up_at=?, updated_at=NOW() WHERE id=?', [$followUp, $id]);
    }
    flash('success', 'CRM activity added.');
    redirect('/admin/leads/' . $id);
}

function admin_agents(): void
{
    require_admin();
    $agents = db_all('SELECT * FROM agents ORDER BY id DESC');
    view('admin/agents/index', compact('agents'), 'admin');
}

function admin_agent_form(?int $id = null): void
{
    require_admin();
    $agent = $id ? db_one('SELECT * FROM agents WHERE id = ?', [$id]) : [];
    view('admin/agents/form', [
        'agent' => $agent,
        'heading' => $id ? 'Edit Agent' : 'Add Agent',
        'action' => $id ? url('/admin/agents/' . $id . '/edit') : url('/admin/agents/create'),
    ], 'admin');
}

function agent_payload(): array
{
    return [trim($_POST['agent_name'] ?? ''), trim($_POST['mobile'] ?? ''), trim($_POST['email'] ?? ''), trim($_POST['license_number'] ?? ''), (float) ($_POST['commission_rate'] ?? 0), trim($_POST['service_city'] ?? ''), 'active'];
}

function admin_store_agent(): void
{
    require_admin();
    db_exec('INSERT INTO agents (agent_name, mobile, email, license_number, commission_rate, service_city, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', agent_payload());
    flash('success', 'Agent created.');
    redirect('/admin/agents');
}

function admin_update_agent(int $id): void
{
    require_admin();
    db_exec('UPDATE agents SET agent_name=?, mobile=?, email=?, license_number=?, commission_rate=?, service_city=?, status=?, updated_at=NOW() WHERE id=?', [...agent_payload(), $id]);
    flash('success', 'Agent updated.');
    redirect('/admin/agents');
}

function admin_bookings(): void
{
    require_admin();
    $bookings = db_all('SELECT b.*, p.title FROM bookings b JOIN properties p ON p.id = b.property_id ORDER BY b.id DESC');
    view('admin/bookings/index', compact('bookings'), 'admin');
}

function handle_exception(Throwable $exception): void
{
    $message = $exception->getMessage();
    error_log((string) $exception);
    if (wants_json()) {
        json_response(['success' => false, 'message' => $message], 500);
    }
    http_response_code(500);
    view('static', [
        'title' => 'Configuration Required',
        'heading' => config('app.debug') ? 'Application Error' : 'Setup Required',
        'body' => config('app.debug') ? $message : 'Please configure the database, import database/schema.sql and database/seed.sql, then reload the application.',
    ]);
}
