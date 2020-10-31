<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8" />
    <title>ue8d's Videos</title>
    <link rel="stylesheet" type="text/css" href="./CSS/index.css">
  </head>
  <body style="background-color:white">
    <!-- ヘッダー読み込み -->
    <?php include_once "./header.php" ?>

    <div class="main">
      <p>サンプルムービー</p>
      <?php
        foreach(glob('video/{*.mp4}',GLOB_BRACE) as $file){
          if(is_file($file)){
              //print(htmlspecialchars($file)."<br>");
      ?>
              <a href="./01/play.php?videoPass=<?php print($file) ?>&videoName=<?php print((substr($file, 6, -4))); ?>"><?php print(substr($file,6)); ?></a><br>
      <?php
          }
        }
      ?>
      <br>
      <p>VOD一覧</p>
      <?php
        foreach(glob('encVideo/{*.m3u8}',GLOB_BRACE) as $file){
          if(is_file($file)){
            //print(htmlspecialchars($file)."<br>");
      ?>
            <a href="./02/vod.php?videoPass=<?php print($file) ?>&videoName=<?php print((substr($file,28,-20))); ?>"><?php print(substr($file,28,-5)); ?></a><br>
      <?php
          }
        }
      ?>
      <p>VOD一覧 DB版</p>
      <?php
        require "core/config.php";
        try {
          $dbh = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
          echo "接続失敗: " . $e->getMessage() . "\n";
          exit();
        }

        // SQL
        $sql = 'SELECT * FROM thumb';
        $prepare = $dbh->prepare($sql);
        $prepare->execute();
        //連想配列として保存
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        // 結果を出力
        $id = array_column($result, "id");
        $videoName = array_column($result, "videoName");
        $videoPath = array_column($result, "videoPath");
        //$thumbPath = array_column($result, "thumbPath");
        for ($i=0; $i < count($id); $i++) {
        ?>
          <a href="./02/vod.php?videoPass=<?php echo $videoPath[$i]; ?>&videoName=<?php echo $videoName[$i]; ?>"><?php echo $videoName[$i]; ?></a><br>
        <?php
        }
      ?>
    </div>

    <footer class="index">
      <p>© All rights reserved by ue8d.</p>
    </footer>
  </body>
</html>