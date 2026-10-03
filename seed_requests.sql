-- Seed 3 sample document request transactions

INSERT INTO `requests` (`requester_name`, `requester_email`, `item_name`, `quantity`, `purpose`, `status`, `created_at`, `updated_at`) VALUES

('Alon Cruz', 'alon@gmail.com', 'Certificate of Employment', 1, 'Required for visa application to Japan', 'pending', NOW(), NOW()),
('Jane Lim', 'jane.lim@gmail.com', 'Transcript of Records', 2, 'Needed for graduate school application', 'approved', NOW(), NOW()),
('Mike Santos', 'mike.s@gmail.com', 'Barangay Clearance', 1, 'Business permit renewal requirement', 'rejected', NOW(), NOW());

