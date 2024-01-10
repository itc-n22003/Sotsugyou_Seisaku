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
      echo "<h2>選択したファイル</h2>";
      echo "<code>$file</code>";

      echo "<h2>ファイルの内容</h2>";
      $file_extension = pathinfo($file, PATHINFO_EXTENSION);

      # 画像ファイルの場合は画像を表示
      if($file_extension === "jpg" || $file_extension === "png"){

        # 入力された画像ファイルがpictureディレクトリにある場合はpictureディレクトリの画像を表示
        if(file_exists("./picture/$file")){
          echo "<img src=./picture/$file width=100%>";
        }

        # pictureディレクトリにない場合は別のサーバーから取得して表示
        else {
          $image = file_get_contents($file);
          $encode = base64_encode($image);
          $info =  getimagesize('data:application/octet-stream;base64,' . $encode);
          $source = 'data:' . $info['mime'] . ';base64,' . $encode;
          echo "<img src=$source width=100%>";
        }
      }
      
      # ログファイルの場合はログを表示
      else if($file_extension === "log"){
        $result = nl2br(file_get_contents("./log/$file"));
        echo "<code>$result</code>";
      }
      
      # 画像ファイルやログファイル以外で、サーバー上にファイルがある場合はそのまま表示し、ない場合は別のサーバーから取得して表示
      else {
        $result = nl2br(file_get_contents($file));
        echo "<code>$result</code>";
      }
    }
  ?>
</body>
</html>
