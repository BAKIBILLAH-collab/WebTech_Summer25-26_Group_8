<?php
$pageTitle = 'CareShelf - Pay / Renew Membership';
require_once __DIR__ . '/../Model/Session.php';
requireLogin();
require_once __DIR__ . '/../Model/UserModel.php';
$customer = (new UserModel())->getCustomerById((int) ($_SESSION['user_id'] ?? 0)) ?? [];
require_once __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">Pay / Renew Membership</h1>

<div class="notice-box notice-info">
    Choose a membership plan below and complete payment to activate or renew your account.
</div>

<form action="payment_receipt_new.php" method="post" onsubmit="return validateMembershipForm();">
    <div class="plan-grid">
        <label class="plan-card">
            <input type="radio" name="plan" value="monthly" checked required>
            <div class="plan-body">
                <div class="plan-name">Monthly Plan</div>
                <div class="plan-price">BDT 15.00</div>
                <div class="plan-desc">
                    Valid for 1 month. Borrow up to 7 books.
                </div>
            </div>
        </label>

        <label class="plan-card">
            <input type="radio" name="plan" value="annual">
            <div class="plan-body">
                <div class="plan-name">Annual Plan</div>
                <div class="plan-price">BDT 120.00</div>
                <div class="plan-desc">
                    Valid for 12 months. Best value. Borrow up to 7 books.
                </div>
            </div>
        </label>
    </div>

    <table class="form-table" style="margin-top:24px;">
        <tr>
            <td class="label"><label for="customer_name">Full Name:</label></td>
            <td>
                <input
                    type="text"
                    name="customer_name"
                    id="customer_name"
                    value="<?php echo htmlspecialchars((string) ($customer['full_name'] ?? $_SESSION['user_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>"
                    readonly
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="payment_method">Payment Method:</label></td>
            <td>
                <select name="payment_method" id="payment_method">
                    <option value="bkash">Bkash</option>
                    <option value="nagad">Nagad</option>
                    <option value="rocket">Rocket</option>
                    <option value="cash">Cash</option>
                </select>
            </td>
        </tr>

        <tr>
            <td class="label"><label for="transaction_id">Transaction ID:</label></td>
            <td>
                <input
                    type="text"
                    name="transaction_id"
                    id="transaction_id"
                    placeholder="e.g. BKH20260822XXXXX"
                >
            </td>
        </tr>

        <tr>
            <td class="label"><label for="payment_date">Payment Date:</label></td>
            <td>
                <input
                    type="date"
                    name="payment_date"
                    id="payment_date"
                    value="<?php echo date('Y-m-d'); ?>"
                    required
                >
            </td>
        </tr>
    </table>

    <div class="button-row">
        <button class="btn" type="submit">Confirm Payment</button>
        <button class="btn btn-alt" type="reset">Clear</button>
    </div>
</form>

<div class="link-row">
    <a href="membership_required.php">Back to Membership Alert</a> |
    <a href="index.php">Back to menu</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
