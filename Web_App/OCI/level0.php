<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>OS Command Injection</title>
</head>
<body>
  <h1>Ping Tester</h1>
  <h2>Pingを送るアドレス/ドメイン</h2>
  <form action="" method="post">
    <input type="text" name="address" placeholder="IPアドレス/ドメイン">
    <input type="submit" value="送信">
  </form>
  <?php
    # 入力がある場合に処理
    if(!empty($_POST["address"])){
      echo "<h2>送ったIPアドレス/ドメイン</h2>";
      $target_address = $_POST["address"];
      echo "<code>$target_address</code>";

      echo "<h2>Pingの結果</h2>";
      ob_start();
      # 入力されたIPアドレス、またはドメインに対してpingを送信
      passthru("ping -c 3 $target_address");
      $result = nl2br(ob_get_contents());
      ob_end_clean();
      echo "<code>$result</code>";
    }
  ?>
</body>
</html>
