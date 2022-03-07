<?php
session_start();

if (isset($_SESSION["userid"]) || $_SESSION["userid"] !== true) {
  header("location: login.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">>
        <h1>Hello, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong></h1>
      </div>
      <p>
        <a href="reset-password.php" class="btn btn-warning">パスワードリセット</a>
        <a href="logout.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">ログアウト</a>
      </p>
    </div>
  </div>
</body>

</html>
