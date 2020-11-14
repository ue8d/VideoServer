<?php
  session_start();
  if(isset($_GET['keyword'])) {
      $keyword = htmlspecialchars($_GET['keyword']);

      //DB接続
      require "core/config.php";
      try {
        $dbh = new PDO($dsn, $username, $password);
      } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
      }
      // SQL
      $sql = 'SELECT * FROM thumb WHERE videoName LIKE :keyword';
      $prepare = $dbh->prepare($sql);
      $prepare->bindValue(':keyword', "%".$keyword."%", PDO::PARAM_STR);
      $prepare->execute();
      //連想配列として保存
      $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
      // 結果を出力
      $id = array_column($result, "id");
      $videoName = array_column($result, "videoName");
      $videoPath = array_column($result, "videoPath");
      $thumbPath = array_column($result, "thumbPath");
  }else{
      $keyword = null;
  }