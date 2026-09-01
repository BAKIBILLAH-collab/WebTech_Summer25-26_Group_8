<?php
$pageTitle='CareShelf - Login';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/Model/app.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    [$database,$conn]=getDatabase();$username=trim($_POST['username']??'');$password=$_POST['password']??'';
    $stmt=$conn->prepare("SELECT id,password,full_name FROM users WHERE username=? OR email=? LIMIT 1");$stmt->bind_param('ss',$username,$username);$stmt->execute();$user=$stmt->get_result()->fetch_assoc();$stmt->close();
    if($user && password_verify($password,$user['password'])){$_SESSION['user_id']=(int)$user['id'];$database->close();header('Location: index.php');exit;}else $error='Invalid username/email or password.';$database->close();
}
?>
<h1 class="page-title">Login</h1>
<?php if($error): ?><div class="notice-box notice-danger">&#9888; <?php echo h($error); ?></div><?php endif; ?>
<form method="post"><table class="form-table"><tr><td class="label"><label for="username">Username / Email:</label></td><td><input id="username" name="username" required></td></tr><tr><td class="label"><label for="password">Password:</label></td><td><input type="password" id="password" name="password" required></td></tr></table><div class="button-row"><button class="btn" type="submit">Login</button></div></form>
<div class="link-row"><a href="register_gourab.php">Create Account</a> | <a href="index.php">Back to menu</a></div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
