<?php
session_start();

// Admin Access Control Check
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    echo "<tr><td colspan='7' class='text-center text-danger py-3'>Unauthorized access</td></tr>";
    exit();
}

include '../database/db.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

// Manual string escaping loop
$clean_q = "";
$q_len = 0;
while (isset($q[$q_len])) {
    $q_len++;
}
for ($i = 0; $i < $q_len; $i++) {
    if ($q[$i] == "'") {
        $clean_q .= "\\'";
    } else {
        $clean_q .= $q[$i];
    }
}

if ($clean_q != "") {
    $sql = "SELECT * FROM appointments 
            WHERE name LIKE '%$clean_q%' 
               OR email LIKE '%$clean_q%' 
               OR phone LIKE '%$clean_q%' 
               OR department LIKE '%$clean_q%' 
               OR appointment_date LIKE '%$clean_q%' 
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM appointments ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);

$avatars = [
    'images/testimonial-1.jpg',
    'images/testimonial-2.jpeg',
    'images/testimonial-3.jpg',
    'images/testimonial-4.jpeg',
    'images/testimonial-5.jpeg',
    'images/testimonial-6.jpeg'
];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $avatar_url = $avatars[$row['id'] % count($avatars)];
        $formatted_date = date('d-m-Y', strtotime($row['appointment_date']));
        $safe_name = htmlspecialchars($row['name']);
        $safe_email = htmlspecialchars($row['email']);
        $safe_phone = htmlspecialchars($row['phone']);
        $safe_dept = htmlspecialchars($row['department']);
        $safe_time = htmlspecialchars($row['appointment_time']);
        $safe_msg = $row['message'] ? htmlspecialchars($row['message']) : '-';
        $row_id = $row['id'];

        echo "<tr>
            <td>{$row_id}</td>
            <td>
                <div class='d-flex align-items-center'>
                    <img src='{$avatar_url}' class='rounded-circle me-2' style='width:32px; height:32px; object-fit:cover; border: 1px solid rgba(13, 110, 253, 0.15); background:#fff;'>
                    <strong>{$safe_name}</strong>
                </div>
            </td>
            <td>
                <small class='text-muted'><i class='fas fa-envelope'></i> {$safe_email}</small><br>
                <small class='text-muted'><i class='fas fa-phone'></i> {$safe_phone}</small>
            </td>
            <td><span class='badge bg-light text-primary'>{$safe_dept}</span></td>
            <td>
                <small><i class='fas fa-calendar'></i> {$formatted_date}</small><br>
                <small><i class='fas fa-clock'></i> {$safe_time}</small>
            </td>
            <td><small class='text-muted'>{$safe_msg}</small></td>
            <td>
                <div class='d-flex gap-1'>
                    <a href='admin.php?edit_id={$row_id}#appointment-form-section' class='btn btn-sm btn-outline-primary py-1' title='Edit'><i class='fas fa-edit'></i></a>
                    <a href='javascript:void(0);' onclick='confirmDeleteAppointment({$row_id})' class='btn btn-sm btn-outline-danger py-1' title='Delete'><i class='fas fa-trash-alt'></i></a>
                </div>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center text-muted py-4'><i class='fas fa-search me-1'></i> No matching appointments found.</td></tr>";
}
?>
