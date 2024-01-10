<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>OS Command Injection</title>
</head>
<body>
  <h1>Ping Tester</h1>
  <h2>Pingを送るアドレス</h2>
  <form action="" method="post">
    <input type="text" name="address" placeholder="IPアドレス">
    <input type="submit" value="送信">
  </form>
  <?php
    # 使用してはいけない文字列を配列として格納
    $filter = array(";", "&", "|");

    # 入力値がある場合に処理
    if(!empty($_POST["address"])){
      $target_address = $_POST["address"];

      # foreach文でフィルタリング
      foreach($filter as $item){

        # 使用してはいけない文字列がある場合メッセージを表示して終了
        if(strpos($target_address, $item) !== false){
          echo "<code>Do Not use \"$item\".</code>";
          exit();
        }
      }
      echo "<h2>送ったIPアドレス</h2>";
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
