<?php
echo '<!DOCTYPE HTML>
<html lang="en">

<head>';

//<Error Handling-->
//
//<Attach css stylesheet-->
//
//only alert user of file non existance as possible to function without file-->
if (!file_exists("style.css")){
    echo "<script> alert('CSS stylesheet file not found!')</script>";

}else {
   echo '<link rel="stylesheet" type="text/css" href="style.css">';  
}

?>

<!--//kill the page as header necessary to for page functionality-->
<!--Include header and die if not available-->
<?php if (!file_exists("header.php")){
    die("Error:file header.php not found");
}else {
   include 'header.php';  
}
?>



<?php 
//<!--//kill the page as header necessary to for page functionality-->
//
//<!--Include header and die if not available-->


if (!file_exists("dbconfig.php")){
   die("Error: file dbconfig.php not found!");
}else{
        require_once'dbconfig.php';
    }
//https://www.w3schools.com/php/php_mysql_create_table.asp

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT`customerName`,`country`,`city`,`phone` FROM `customers` ORDER BY `customers`.`country` ASC";
$result = $conn->query($sql);

//code based on error handling lecture
//function to test if SQL query contains Errors

function checkResults($result){
    if ($result->num_rows < 4){
        throw new Exception("Error in SQL query!");
}
 return true;
}
try{
  checkResults($result);  
}
//catch exceptions
catch(Exception $e){
    echo 'Message: '.$e-> getMessage();
    die;
}
//if results are valid echo data to the webpage

if ($result->num_rows > 0) {
    
    echo "<h1> Customer Details Table</h1><div class='box'>
    <table id='My-Table' class='content-table'><tr><th>customerName</th><th>country</th><th>city</th><th>phone</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["customerName"]."</td><td>".$row["country"]."</td><td>".$row["city"]."</td><td>".$row["phone"]."</td></tr>";
    }
    echo "</table>
    </div>";
} else {
    echo "0 results";
}
$conn->close();
?>
<?php if (!file_exists("footer.php")){
    echo "<script> alert('Error: footer.php not found!')</script>";
    

}else {
   include 'footer.php';  
}
echo '</body></html>';
?>





























