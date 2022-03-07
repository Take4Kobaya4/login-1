<?php
// ファイルの取得
require_once "config.php";
require_once "session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  if ($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
    $error = '';

    $query->bind_param('s', $email);
    $query->execute();

    $query->store_result();
    if ($query->num_rows > 0) {
      $error = '<p class="error">そのメールアドレスは既に登録されています。</p>';
    } else {
      if (strlen($password) < 8) {
        $error = '<p class="error">パスワードは少なくとも8文字以上でお願いします。</p>';
      }
      if (empty($confirm_password)) {
        $error = '<p class="error">確認用パスワードを入れてください。</p>';
      } else {
        if (empty($error) && ($password != $confirm_password)) {
          $error = '<p class="error">パスワードが一致していません。</p>';
        }
      }
      if (empty($error)) {
        $insertQuery = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?);");
        $insertQuery->bind_param("sss", $username, $email, $password_hash);
        $result = $insertQuery->execute();
        if ($result) {
          $error = '<p class="success">登録が完了しました！</p>';
        } else {
          $error = '<p class="error">何かが間違っています。</p>';
        }
      }
    }
  }

  $query->close();
  $insertQuery->close();

  mysqli_close($db);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>新規登録</h2>
        <p>アカウント作成のために、フォーム内を埋めてください。</p>
        <form action="" method="post">
          <div class="form-group">
            <label>名前</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="form-group">
            <label>確認用パスワード</label>
            <input type="password" name="confirm_password" class="form-control" required>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
          </div>
          <p>既にアカウントはお持ちですか？<a href="login.php">こちらへログイン</a></p>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
