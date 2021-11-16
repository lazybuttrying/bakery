<?php 

  // 한글 깨짐 방지
  header("Content-Type: text/html; charset=euc-kr");
  
  if ($_FILES["file"]["error"] > 0){
    echo "ERROR : ".$_FILES["file"]["error"]."<br/>";
  } else {
    $filename = "./file/".$_FILES["file"]["name"];
      
    if (file_exists($filename)) {
      echo "Same name file is already in";
    }
    else { 
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Stored in: " . $_FILES["file"]["tmp_name"]."<br><br>";

      // 확장자 검사 - only csv
      $fileType = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
      echo $fileType."<br>";
      switch ($fileType){
        case 'csv':
       // case 'xlsx':  
          move_uploaded_file($_FILES['file']['tmp_name'], $filename);
          break;
        default:
          echo "Wrong file format";
          echo "It muse be 'csv'";
          exit();
      }

    }
  }

  function saveContent($filename){
    $mysqli = mysqli_connect("localhost", "root", "", "bakerydb");
    
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
    // 엑셀 시트 속 column 확인하기
    $fp = @fopen($filename, "r") or die("Error!\n");
    echo fgets($fp)."<br>"; // remove column name (first row)

    while (!feof($fp)) {
        $sql = "INSERT into order (menu_id, user_id, order_id, datetime, day_of_week, count, total) values (' ".$_POST["testColumn"]." ')";
        $result = mysqli_query($mysqli, $sql);
          if ($result === TRUE) {
             echo "A record has been inserted";
          } else {
             printf("Could not insert record: %s\n", mysqli_connect_error());
          }
    }
    fclose($fp);
  
    mysqli_close($mysqli);  //4. Close connection
  }

  
?>
