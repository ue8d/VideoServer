<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8" />
    <title>いんでっくす</title>
  </head>
  <body style="background-color:white">
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
      foreach(glob('workspace/{*.m3u8}',GLOB_BRACE) as $file){
        if(is_file($file)){
          //print(htmlspecialchars($file)."<br>");
    ?>
          <a href="./02/vod.php?videoPass=<?php print($file) ?>&videoName=<?php print((substr($file, 10, -5))); ?>"><?php print(substr($file,10,-5)); ?></a>
    <?php
        }
      }
    ?>
  </body>
</html>