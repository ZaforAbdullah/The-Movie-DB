<html>
<title>Install DB</title>
<head>
</head>

<body>

<form action="index.php" method="GET">
    <left><table>
    <tr>
        <td>Go back to search</td>
        <td><input type="submit" name="submit"></td>
    </tr>
    </table></left>
</form>

<?php
include_once 'dbclass.php';
include_once ('moviecontroller.php');

$api_key = "a48c836b1c63a94110904d929e41caf6";
$size = "w92";   //size list -  w92, w154, w185, w342, w500, w780, original
$enablePageSize = true;   //false - store all the movies  |  true - only store specified page size movies
$pageSize = 1;   // 1 page has 20 movies

try 
{
  $dbclass = new DBClass();
  $connection = $dbclass->getConnection();
  $sql = file_get_contents("./config/database.sql");
  $res = $connection->exec($sql);
  echo "Database and tables created successfully!<br>";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

$files = glob('config/images/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

$movieController =  new MovieController();

$json = file_get_contents('https://api.themoviedb.org/3/configuration?api_key='.$api_key);
$json2 = file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key='.$api_key.'&language=en-US&page=1');

$obj = json_decode($json, TRUE);
$obj2 = json_decode($json2, TRUE);

$base_url = $obj['images']['base_url'];
$secure_base_url = $obj['images']['secure_base_url'];
$poster_sizes = $obj['images']['poster_sizes'];
$total_pages = $enablePageSize ? $pageSize : $obj2['total_pages'];

for ($x = 1; $x <= $total_pages; $x++) {
    $json3 = file_get_contents("https://api.themoviedb.org/3/movie/popular?api_key=".$api_key."&language=en-US&page=1".$x);
    $obj3 = json_decode($json3, TRUE);
    $results = $obj3['results'];
    foreach ($results as $result) {
        $poster_path = $result['poster_path'];

        if($poster_path==NULL){
          echo "skipping. no image in movie.<br>";
          continue;
        }
        $url = $secure_base_url . $size . $poster_path;
        $title = $result['title'];
        $id = $result['id'];
        $description = $result['overview'];
        $location = "config/images" . $poster_path;
        file_put_contents($location, file_get_contents($url));

        $parameters = array("id" => $id, "title" => $title, "description" => $description, "url" => $url, "location" => $location);
        $res = $movieController->create($parameters);
        if($res){
          echo "movie id ". $id. " added.<br>";
        }else{
          echo "Skipping. Already exists movie id ". $id. ".<br>";
        }
    }
}

echo "all movies saved successfully!<br>";

?>

</body>

</html>