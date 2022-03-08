<?php

require_once "config.php";
require_once "session.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

  $username = trim($_POST["email"]);
  $password = trim($_POST["password"]);
  // ユーザー名が空である場合での挙動
  if (empty($email)) {
    $error = '<p class="error">メールアドレスを入力してください。</p>';
  }
  // パスワードが空である場合での挙動
  if (empty($password)) {
    $error = '<p class="error">パスワードを入力してください。</p>';
  }
  // エラーがない場合での挙動
  if (empty($error)) {
    if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
      $query->bind_param('s', $email);
      $query->execute();
      $row = $query->fetch();
      if ($row) {
        if (password_verify($password, $row['password'])) {
          $_SESSION["userid"] = $row['id'];
          $_SESSION["user"] = $row;

          header("location: welcome.php");
          exit;
        } else {
          $error = '<p class="error">そのパスワードは無効です。</p>';
        }
      } else {
        $error = '<p class="error">そのメールアドレスは存在していません。</p>';
      }
    }
    $query->close();
  }

  mysqli_close($db);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>ログイン</h2>
        <p>メールアドレスとパスワードを入力してください。</p>
        <form action="" method="post">
          <div class="from-group">
            <label>メールアドレス</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="from-group">
            <label>パスワード</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="ログイン">
          </div>
          <div class="form-group">

            <p>アカウントはお持ちではありませんか？<a href="register.php">登録はこちら！</a></p>
            <a href="forget_password.php" class="ForgetPwd">パスワードお忘れの場合はこちらへ</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
