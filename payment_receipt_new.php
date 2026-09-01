<?php
$pageTitle = 'CareShelf - Payment Receipt';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';

[$database, $conn] = getDatabase();
$userId = currentUserId($conn);
$message = '';
$error = '';
$payment = null;
$membership = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'] ?? 'monthly';
    $paymentMethod = $_POST['payment_method'] ?? 'bkash';
    $transactionId = trim($_POST['transaction_id'] ?? '');
    if ($transactionId === '') { $transactionId = 'CS-' . date('YmdHis') . '-' . $userId; }
    $paymentDate = $_POST['payment_date'] ?? date('Y-m-d');
    $customerName = trim($_POST['customer_name'] ?? '');

    $planName = $plan === 'annual' ? 'Annual Membership' : 'Monthly Membership';
    $amount = $plan === 'annual' ? 120.00 : 15.00;
    $months = $plan === 'annual' ? 12 : 1;
    $expiryDate = date('Y-m-d', strtotime($paymentDate . " +$months month"));

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO payments (user_id,plan,amount,payment_method,transaction_id,payment_date) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('isdsss', $userId, $planName, $amount, $paymentMethod, $transactionId, $paymentDate);
        if (!$stmt->execute()) throw new Exception('Could not save payment: ' . $stmt->error);
        $paymentId = $stmt->insert_id;
        $stmt->close();

        $status = 'Active';
        $stmt = $conn->prepare("INSERT INTO memberships (user_id,plan,amount,start_date,expiry_date,status) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param('isdsss', $userId, $planName, $amount, $paymentDate, $expiryDate, $status);
        if (!$stmt->execute()) throw new Exception('Could not save membership: ' . $stmt->error);
        $stmt->close();

        $stmt = $conn->prepare("UPDATE users SET membership_status='Active', expiry_date=? WHERE id=?");
        $stmt->bind_param('si', $expiryDate, $userId);
        if (!$stmt->execute()) throw new Exception('Could not update user membership: ' . $stmt->error);
        $stmt->close();

        $conn->commit();
        $message = 'Payment, membership and user membership status saved successfully.';
        $payment = ['id'=>$paymentId,'customer_name'=>$customerName,'payment_date'=>$paymentDate,'plan'=>$planName,'amount'=>$amount,'payment_method'=>ucfirst($paymentMethod),'transaction_id'=>$transactionId];
        $membership = ['start_date'=>$paymentDate,'expiry_date'=>$expiryDate,'status'=>'Active'];
    } catch (Throwable $e) {
        $conn->rollback();
        $error = $e->getMessage();
    }
}

$database->close();
?>

<h1 class="page-title">Payment Receipt</h1>
<?php if ($message): ?><div class="notice-box notice-success">&#10003; <?php echo h($message); ?></div><?php endif; ?>
<?php if ($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>

<?php if ($payment && $membership): ?>
<div class="receipt-box">
<div class="receipt-header"><span class="receipt-label">OFFICIAL RECEIPT</span><span class="receipt-id">Receipt #: CS-<?php echo date('Y'); ?>-<?php echo (int)$payment['id']; ?></span></div>
<table class="form-table">
<tr><td class="label"><strong>Customer:</strong></td><td><?php echo h(strtoupper($payment['customer_name'])); ?></td></tr>
<tr><td class="label"><strong>Payment Date:</strong></td><td><?php echo h($payment['payment_date']); ?></td></tr>
<tr><td class="label"><strong>Plan:</strong></td><td><?php echo h($payment['plan']); ?></td></tr>
<tr><td class="label"><strong>Amount (BDT):</strong></td><td><?php echo number_format($payment['amount'],2); ?></td></tr>
<tr><td class="label"><strong>Payment Method:</strong></td><td><?php echo h($payment['payment_method']); ?></td></tr>
<tr><td class="label"><strong>Transaction ID:</strong></td><td><?php echo h($payment['transaction_id'] ?: 'N/A'); ?></td></tr>
<tr><td class="label"><strong>Membership Status:</strong></td><td><span class="badge badge-success">Active</span></td></tr>
<tr><td class="label"><strong>Valid From:</strong></td><td><?php echo h($membership['start_date']); ?></td></tr>
<tr><td class="label"><strong>Expiry Date:</strong></td><td><?php echo h($membership['expiry_date']); ?></td></tr>
</table>
</div>
<?php endif; ?>
<div class="button-row"><a class="btn" href="index.php">Back to Dashboard</a><a class="btn btn-alt" href="pay_membership.php">Pay Again</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
