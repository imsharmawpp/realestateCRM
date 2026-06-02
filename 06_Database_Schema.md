# Database Design

## users

- id
- name
- email
- mobile
- password_hash
- role
- status
- email_verified_at
- mobile_verified_at
- created_at
- updated_at

## agents

- id
- user_id
- agent_name
- mobile
- email
- license_number
- commission_rate
- service_city
- status
- created_at
- updated_at

## properties

- id
- agent_id
- title
- slug
- description
- price
- location
- city
- state
- pincode
- property_type
- bhk
- carpet_area
- built_up_area
- furnishing_status
- construction_status
- possession_date
- status
- created_at
- updated_at

## property_media

- id
- property_id
- media_type
- file_path
- sort_order
- created_at

## leads

- id
- customer_name
- mobile
- email
- property_id
- assigned_agent_id
- lead_source
- lead_score
- lead_status
- next_follow_up_at
- created_at
- updated_at

## bookings

- id
- property_id
- customer_id
- agent_id
- booking_amount
- total_amount
- payment_status
- booking_status
- agreement_file
- created_at
- updated_at

## transactions

- id
- booking_id
- payment_gateway
- gateway_order_id
- gateway_payment_id
- amount
- currency
- payment_status
- invoice_number
- paid_at
- created_at

## crm_activities

- id
- lead_id
- agent_id
- activity_type
- remarks
- next_follow_up_at
- created_at

## message_templates

- id
- channel
- template_name
- template_body
- provider_template_id
- status
- created_at
- updated_at

## automation_logs

- id
- lead_id
- booking_id
- channel
- template_id
- recipient
- status
- provider_response
- sent_at
- created_at
