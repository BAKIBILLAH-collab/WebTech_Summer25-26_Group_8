<?php
$pageTitle = 'CareShelf - Payment Receipt';
require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/PaymentModel.php';
require_once __DIR__ . '/../Model/UserModel.php';

$customerId = (int) ($_SESSION['user_id'] ?? 0);
$customer = (new UserModel())->getCustomerById($customerId) ?? [];
$allowedPlans = [
    'monthly' => ['name' => 'Monthly Membership', 'amount' => 15.00, 'months' => 1],
    'annual' => ['name' => 'Annual Membership', 'amount' => 120.00, 'months' => 12],
];
$allowedMethods = ['bkash', 'nagad', 'rocket', 'cash'];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $plan = $_POST['plan'] ?? '';
    $paymentMethod = $_POST['payment_method'] ?? '';
    $paymentDate = $_POST['payment_date'] ?? '';
    $today = date('Y-m-d');

    if (!isset($allowedPlans[$plan]) || !in_array($paymentMethod, $allowedMethods, true)
        || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $paymentDate) || $paymentDate > $today) {
        $error = 'Please provide valid payment details.';
    } else {
        $planDetails = $allowedPlans[$plan];
        $baseDate = $paymentDate;
        if (!empty($customer['membership_expiry_date']) && $customer['membership_expiry_date'] >= $paymentDate) {
            $baseDate = $customer['membership_expiry_date'];
        }
        $expiryDate = date('Y-m-d', strtotime($baseDate . ' +' . $planDetails['months'] . ' months'));
        $receiptNo = 'CS-' . date('YmdHis') . '-' . random_int(100, 999);

        (new PaymentModel())->createPayment(
            $customerId,
            $planDetails['amount'],
            $paymentDate,
            $expiryDate,
            $receiptNo,
            $paymentMethod
        );

        $payment = [
            'customer' => $customer['full_name'] ?? $_SESSION['user_name'] ?? 'Customer',
            'payment_date' => $paymentDate,
            'plan_name' => $planDetails['name'],
            'amount' => $planDetails['amount'],
            'payment_method' => ucfirst($paymentMethod),
            'receipt_no' => $receiptNo,
            'expiry_date' => $expiryDate,
        ];
    }
}
$payments = (new PaymentModel())->getPayments($customerId);
?>
<?php require_once __DIR__ . '/includes/header.php'; ?>

<h1 class="page-title">Payment Receipt</h1>

<?php if ($error !== ''): ?>
    <div class="notice-box notice-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <div class="button-row"><a class="btn" href="pay_membership.php">Return to Payment</a></div>
<?php elseif (isset($payment)): ?>
    <div class="notice-box notice-success">Payment recorded successfully. Your membership is active.</div>
    <div class="receipt-box">
        <div class="receipt-header"><span class="receipt-label">OFFICIAL RECEIPT</span><span class="receipt-id">Receipt #: <?= htmlspecialchars($payment['receipt_no'], ENT_QUOTES, 'UTF-8') ?></span></div>
        <table class="form-table">
            <tr><td class="label">Customer:</td><td><?= htmlspecialchars(strtoupper($payment['customer']), ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Payment Date:</td><td><?= htmlspecialchars($payment['payment_date'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Plan:</td><td><?= htmlspecialchars($payment['plan_name'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Amount (BDT):</td><td><?= number_format($payment['amount'], 2) ?></td></tr>
            <tr><td class="label">Payment Method:</td><td><?= htmlspecialchars($payment['payment_method'], ENT_QUOTES, 'UTF-8') ?></td></tr>
            <tr><td class="label">Membership Status:</td><td><span class="badge badge-success">Active</span></td></tr>
            <tr><td class="label">Expiry Date:</td><td><?= htmlspecialchars($payment['expiry_date'], ENT_QUOTES, 'UTF-8') ?></td></tr>
        </table>
    </div>
    <div class="button-row"><a class="btn" href="index.php">Back to Dashboard</a></div>
<?php else: ?>
    <div class="notice-box notice-info">No new payment receipt is available.</div>
<?php endif; ?>

<h2 class="section-title">Payment History</h2>
<div class="membership-status-wrap receipt-box">
    <table class="membership-status-list form-table">
        <tr>
            <th>Receipt Number</th>
            <th>Payment Date</th>
            <th>Amount (BDT)</th>
            <th>Payment Method</th>
            <th>Membership Expiry</th>
        </tr>
        <?php foreach ($payments as $paymentRecord): ?>
            <tr>
                <td><?= htmlspecialchars($paymentRecord['receipt_no'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($paymentRecord['payment_date'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= number_format((float) $paymentRecord['amount'], 2) ?></td>
                <td><?= htmlspecialchars(ucfirst($paymentRecord['payment_method']), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($paymentRecord['expiry_date'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
        <?php if ($payments === []): ?>
            <tr><td colspan="5" class="empty-state">No payment history is available.</td></tr>
        <?php endif; ?>
    </table>
</div>

<div class="link-row"><a href="membership_required.php">Membership Status</a> | <a href="index.php">Back to menu</a></div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
