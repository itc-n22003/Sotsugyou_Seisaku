<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>LFI - 物置</title>
</head>
<body>
  <h1>物置</h1>
  <h2>ファイルを選択</h2>
  <form action="" method="post">
    <input type="text" name="file">
    <input type="submit" value="送信">
  </form>
  <?php
    # 指定したディレクトリにあるファイルを表示するための関数
    function get($dir){
      $count = 0;
      foreach(glob($dir) as $file){
        $count++;
        $filename = basename($file);
        echo "<code>ITEM $count -> $filename</code>";
        echo "<br>";
      }
    }

    echo "<h3>写真</h3>";
    get("./picture/*");

    echo "<h3>Apache2のログ</h3>";
    get("./log/*");
  ?>

  <?php
    # 入力がある場合に処理
    if(!empty($_POST["file"])){
      echo "<h2>選択したファイル</h2>";
      $file = $_POST["file"];
      echo "<code>$file</code>";

      echo "<h2>ファイルの内容</h2>";

      # 画像ファイルの場合は画像を表示
      if(strpos($file, "jpg") !== false){
        echo "<img src=./picture/$file width=100%>";
      }

      # ログファイルの場合はログを表示
      else if(strpos($file, "log") !== false){
        ob_start();
        readfile("./log/$file");
        $result = ob_get_contents();
        ob_end_clean();
        $result = nl2br($result);
        echo "<code>$result</code>";
      }
    }
  ?>
</body>
</html>
