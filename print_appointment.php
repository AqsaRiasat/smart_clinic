<?php
session_start();
require_once 'database/db.php';

// Check authentication (user or admin session)
if (!isset($_SESSION['patient_id']) && !isset($_SESSION['admin_logged_in'])) {
    header("Location: user_login.php");
    exit();
}

// Check appointment ID parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Appointment ID'); window.location='dashboard.php';</script>";
    exit();
}

$app_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch appointment details
if (isset($_SESSION['admin_logged_in'])) {
    // Admin can view any appointment
    $query = mysqli_query($conn, "SELECT * FROM appointments WHERE id='$app_id'");
} else {
    // Patient can only view their own appointments
    $patient_id = $_SESSION['patient_id'];
    $query = mysqli_query($conn, "SELECT * FROM appointments WHERE id='$app_id' AND user_id='$patient_id'");
}

$appointment = mysqli_fetch_assoc($query);

if (!$appointment) {
    echo "<script>alert('Appointment not found or unauthorized access!'); window.location='dashboard.php';</script>";
    exit();
}

$today = date('Y-m-d');
$app_date = $appointment['appointment_date'];
if ($app_date < $today) {
    $status = "Completed";
    $status_color = "#10b981";
} elseif ($app_date == $today) {
    $status = "Today";
    $status_color = "#3b82f6";
} else {
    $status = "Upcoming / Confirmed";
    $status_color = "#0d6efd";
}

$token_no = "SC-" . str_pad($appointment['id'], 5, '0', STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Slip - <?php echo $token_no; ?> - Smart Clinic</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='45' fill='%230d6efd'/><path d='M30 30 L30 70 L70 70 L70 30 Z' fill='white' stroke='white' stroke-width='3'/><rect x='45' y='40' width='10' height='30' fill='%230d6efd'/><rect x='35' y='50' width='30' height='10' fill='%230d6efd'/></svg>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 15px;
        }
        .action-toolbar {
            width: 100%;
            max-width: 750px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .slip-card {
            width: 100%;
            max-width: 750px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            position: relative;
        }
        /* Top Header Strip */
        .slip-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            padding: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            border-bottom: 4px solid #f59e0b;
        }
        .clinic-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .clinic-brand i {
            font-size: 32px;
            background: rgba(255, 255, 255, 0.15);
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .clinic-brand h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .clinic-brand p {
            margin: 0;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }
        .token-box {
            text-align: right;
            background: rgba(255, 255, 255, 0.12);
            padding: 10px 18px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .token-box small {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.85);
            display: block;
        }
        .token-box span {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Slip Content */
        .slip-body {
            padding: 35px 30px;
        }

        .status-strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
            padding: 14px 20px;
            border-radius: 12px;
            border: 1px solid #edf2f9;
            margin-bottom: 25px;
        }
        .status-badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            background: <?php echo $status_color; ?>15;
            color: <?php echo $status_color; ?>;
            border: 1px solid <?php echo $status_color; ?>30;
        }

        /* Details Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }
        @media (max-width: 576px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
        .info-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 18px;
            transition: all 0.2s ease;
        }
        .info-item label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 4px;
            display: block;
        }
        .info-item .value {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }
        .info-item .value i {
            color: #0d6efd;
            margin-right: 6px;
        }

        /* Instructions Box */
        .instruction-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 25px;
        }
        .instruction-box h5 {
            font-size: 14px;
            font-weight: 700;
            color: #b45309;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .instruction-box ul {
            margin: 0;
            padding-left: 20px;
            font-size: 12px;
            color: #78350f;
            line-height: 1.6;
        }

        /* Slip Footer */
        .slip-footer {
            border-top: 2px dashed #cbd5e1;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .qr-placeholder {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .qr-code-box {
            width: 55px;
            height: 55px;
            background: #0f172a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            border-radius: 8px;
        }
        .qr-text small {
            display: block;
            font-size: 11px;
            color: #64748b;
        }
        .qr-text strong {
            font-size: 12px;
            color: #0f172a;
        }
        .stamp-box {
            text-align: right;
        }
        .stamp-box .stamp-title {
            font-size: 12px;
            font-weight: 700;
            color: #0d6efd;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stamp-box .stamp-sub {
            font-size: 11px;
            color: #94a3b8;
        }

        /* Print Media Styles */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
            }
            .action-toolbar {
                display: none !important;
            }
            .slip-card {
                box-shadow: none !important;
                border: 1px solid #000000 !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            .slip-header {
                background: #0d6efd !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .status-badge-custom {
                border: 1px solid #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <!-- Toolbar (Hidden during Print) -->
    <div class="action-toolbar">
        <a href="dashboard.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                <i class="fas fa-print me-1"></i> Print / Save PDF
            </button>
        </div>
    </div>

    <!-- Official Appointment Slip Card -->
    <div class="slip-card">
        
        <!-- Header -->
        <div class="slip-header">
            <div class="clinic-brand">
                <i class="fas fa-hospital-user"></i>
                <div>
                    <h2>Smart Clinic</h2>
                    <p>Advanced Healthcare & Diagnostic Center</p>
                </div>
            </div>
            <div class="token-box">
                <small>Token Number</small>
                <span><?php echo $token_no; ?></span>
            </div>
        </div>

        <!-- Body -->
        <div class="slip-body">
            
            <!-- Status & Booking Time Strip -->
            <div class="status-strip">
                <div>
                    <span class="text-muted small d-block">Booking Reference: #<?php echo $appointment['id']; ?></span>
                    <strong class="text-dark">Official Appointment Token</strong>
                </div>
                <div>
                    <span class="status-badge-custom">
                        <i class="fas fa-circle" style="font-size: 8px;"></i> <?php echo $status; ?>
                    </span>
                </div>
            </div>

            <!-- 2-Column Info Grid -->
            <div class="info-grid">
                
                <div class="info-item">
                    <label>Patient Full Name</label>
                    <div class="value"><i class="fas fa-user"></i> <?php echo htmlspecialchars($appointment['name']); ?></div>
                </div>

                <div class="info-item">
                    <label>Department / Specialty</label>
                    <div class="value"><i class="fas fa-stethoscope"></i> <?php echo htmlspecialchars($appointment['department']); ?></div>
                </div>

                <div class="info-item">
                    <label>Scheduled Date</label>
                    <div class="value"><i class="fas fa-calendar-day"></i> <?php echo date('l, F j, Y', strtotime($appointment['appointment_date'])); ?></div>
                </div>

                <div class="info-item">
                    <label>Time Slot</label>
                    <div class="value"><i class="fas fa-clock"></i> <?php echo htmlspecialchars($appointment['appointment_time']); ?></div>
                </div>

                <div class="info-item">
                    <label>Phone Number</label>
                    <div class="value"><i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($appointment['phone']); ?></div>
                </div>

                <div class="info-item">
                    <label>Registered Email</label>
                    <div class="value"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($appointment['email']); ?></div>
                </div>

            </div>

            <?php if (!empty($appointment['message'])): ?>
            <div class="info-item mb-4">
                <label>Doctor Notes / Patient Message</label>
                <div class="value text-muted fs-6" style="font-weight: 400;"><?php echo nl2br(htmlspecialchars($appointment['message'])); ?></div>
            </div>
            <?php endif; ?>

            <!-- Important Instructions -->
            <div class="instruction-box">
                <h5><i class="fas fa-stethoscope"></i> Doctor Instructions</h5>
                <ul>
                    <li>Please arrive at the clinic reception <strong>15 minutes prior</strong> to your scheduled time.</li>
                    <li>Present this appointment slip (digital or printed) at the reception counter.</li>
                    <li>Please bring relevant previous medical prescriptions or diagnostic reports if applicable.</li>
                    <li>For rescheduling or emergency assistance, call our helpline: <strong>+92 (300) 1234567</strong>.</li>
                </ul>
            </div>

            <!-- Slip Footer with Verification Graphic -->
            <div class="slip-footer">
                <div class="qr-placeholder">
                    <div class="qr-code-box">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="qr-text">
                        <small>Scan for Verification</small>
                        <strong>smartclinic.local/verify/<?php echo $token_no; ?></strong>
                    </div>
                </div>

                <div class="stamp-box">
                    <div class="stamp-title"><i class="fas fa-check-circle text-success me-1"></i> Digitally Verified</div>
                    <div class="stamp-sub">Issued by Smart Clinic Management System</div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
