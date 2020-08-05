<html>
<title>Search Results</title>
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
    require_once ('request_handler.php');

    $requestHandler =  new RequestHandler();
    $requestHandler->handleRequest();

?>

</body>

</html>