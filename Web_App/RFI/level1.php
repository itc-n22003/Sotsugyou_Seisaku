<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <title>RFI - 物置</title>
</head>
<body>
  <h1>物置2</h1>
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
      $file = $_POST["file"];
      $file_name = basename($file);
      $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

      echo "<h2>選択したファイル</h2>";
      echo "<code>$file</code>";

      echo "<h2>ファイルの内容</h2>";
      
      # 入力されたファイルの拡張子がjpgの場合は画像を表示
      if($file_extension === "jpg"){
        echo "<img src=./picture/$file_name width=100%>";
      }

      # 入力されたファイルの拡張子がlogの場合はログを表示
      else if($file_extension === "log"){
        $result = nl2br(file_get_contents("./log/$file_name"));
        echo "<code>$result</code>";
      }
    }
  ?>
</body>
</html>
