<?php $title = isset($_GET['videoName']) ? htmlspecialchars($_GET['videoName']) : "読み込めませんでした"; ?>
<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8" />
    <title>Play "<?php echo $title ?>" | ue8d's Videos</title>
    <link rel="stylesheet" type="text/css" href="../lib/video-js.css" />
    <script type="text/javascript">
      var videoPass = "<?php echo htmlspecialchars($_GET['videoPass']); ?>";
    </script>
    <script src="../lib/video.js"></script>
    <script src="index.js"></script>
  </head>
  <body style="background-color:white">
    <p>
      <?php $title ?>
    </p>
    <video id="video1" class="video-js vjs-default-skin vjs-big-play-centered"></video>
    <br>
    <a href="../index.php">トップへ戻る</a>
  </body>
</html>