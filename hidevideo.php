<?php
  if(isset($_POST['hiddenvideo'])) {
    $hiddenvideo = htmlspecialchars($_POST['hiddenvideo']);

    //DB接続
    require "core/config.php";
    try {
      $dbh = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
      echo "接続失敗: " . $e->getMessage() . "\n";
      exit();
    }
    // SQL
    $sql = "INSERT INTO alreadySeenList (thumbId,userId,flag) VALUES (:thumbId,:userId,:flag)";
    $prepare = $dbh->prepare($sql);
    $prepare->bindValue(':thumbId', $hiddenvideo, PDO::PARAM_STR);
    $prepare->bindValue(':userId', $_SESSION["id"], PDO::PARAM_STR);
    $prepare->bindValue(':flag', '1', PDO::PARAM_STR);
    $prepare->execute();
  }