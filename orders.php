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

// create in process Table using sql query

$sql = "SELECT `orderNumber`,`orderDate`,`status` FROM `orders` WHERE `status` = 'In Process'" ;
$result = $conn->query($sql);

//code based on error handling lecture
//function to test if SQL query contains Errors


function checkResults1($result){
    if ($result->num_rows < 3){
        throw new Exception("Error in SQL query!");
}
 return true;
}
try{
  checkResults1($result);  
}
//catch exceptions
catch(Exception $e){
    echo 'Message: '.$e-> getMessage();
    die;
}
//if results are valid echo data to the webpage
if ($result->num_rows > 0) {
    $orderNumber= [];
    
    
    echo 
    "<h2> Orders in Process</h2><div class='box'><table class='content-table'><tr><th>Order number</th><th>Order date</th>
    <th>order status</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($orderNumber,$row["orderNumber"]);
        
        echo "<tr><td><a href ='orders.php?orderNumber=".$row["orderNumber"]."'>".$row["orderNumber"]."</a></td><td>"
            .$row["orderDate"]."</td><td>"
            .$row["status"]."</td></tr>";
    }
    echo "</table></div>";
} else {
    echo "0 results";
}



//create Cancelled table using sql query


$sql = "SELECT `orderNumber`,`orderDate`,`status` FROM `orders` WHERE `status` = 'Cancelled'" ;
$result = $conn->query($sql);


function checkResults2($result){
    if ($result->num_rows < 3){
        throw new Exception("Error in SQL query!");
}
 return true;
}
try{
  checkResults2($result);  
}
//catch exceptions
catch(Exception $e){
    echo 'Message: '.$e-> getMessage();
    die;
}
//if results are valid echo data to the webpage

if ($result->num_rows > 0) {
    echo "<h2> Orders Cancelled</h2><div class='box'><table class='content-table'><tr><th>Order number</th><th>Order date</th>
    <th>order status</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($orderNumber,$row["orderNumber"]);
        
        echo "<tr><td><a href ='orders.php?orderNumber=".$row["orderNumber"]."'>".$row["orderNumber"]."</a></td><td>"
            .$row["orderDate"]."</td><td>"
            .$row["status"]."</td></tr>";
    }
    echo "</table></div>";
} else {
    echo "0 results";
}


//create most recent orders table using sql query.


$sql = "SELECT `orderNumber`,`orderDate`,`status` FROM `orders` ORDER BY `orders`.`orderDate` DESC LIMIT 20" ;
$result = $conn->query($sql);

function checkResults3($result){
    if ($result->num_rows < 3){
        throw new Exception("Error in SQL query!");
}
 return true;
}
try{
  checkResults3($result);  
}
//catch exceptions
catch(Exception $e){
    echo 'Message: '.$e-> getMessage();
    die;
}
//if results are valid echo data to the webpage

if ($result->num_rows > 0) {
    echo "<h2> 20 Most Recent Orders </h2><div class='box'><table class='content-table'><tr><th>Order number</th><th>Order date</th>
    <th>order status</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($orderNumber,$row["orderNumber"]);
        
        echo "<tr><td><a href ='orders.php?orderNumber=".$row["orderNumber"]."'>".$row["orderNumber"]."</a></td><td>"
            .$row["orderDate"]."</td><td>"
            .$row["status"]."</td></tr>";
    }
    echo "</table></div>";
} else {
    echo "0 results";
}





//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++




//https://stackoverflow.com/questions/9696194/how-to-send-a-data-to-php-page-when-clicking-on-a-link

// conditional statement to check if anything has been posted an if so use string to populate sql query.
if(isset($_GET["orderNumber"]))
    {
      $number= $_GET["orderNumber"]; 
    
    
//test to see if $number is valid and exists on the webpage , when conductinga reqeust in the searchbar. such as "http://localhost/phpfiles/orders.php?orderNumber=abcd"
function checkNumber($number,$orderNumber){
    if (!in_array($number, $orderNumber)){
        throw new Exception("Error in SQL query! Order number is not in selected data");
}
return true;
}
try{
checkNumber($number,$orderNumber);
}
//catch exceptions
catch(Exception $e){
echo 'Message: '.$e-> getMessage();
die;
}
 

$sql = "SELECT orders.orderNumber,orders.orderDate, orders.status, products.productCode, products.productLine, products.productName, orders.comments FROM orderdetails,orders,products WHERE orderdetails.orderNumber =orders.orderNumber and products.productCode = orderdetails.productCode and orders.orderNumber =".$number;
$result = $conn->query($sql);



    if ($result->num_rows > 0) {
    
    echo "<h2> Order Details</h2><div class='box'><table id='My-Table3' class='content-table'>
    
    <tr><th>orderNumber</th><th>orderDate</th><th>status</th><th>productCode</th><th>productLine</th><th>productName</th><th>comments</th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["orderNumber"]."</td><td>"
            .$row["orderDate"]."</td><td>"
            .$row["status"]."</td><td>"
            .$row["productCode"]."</td><td>"
            .$row["productLine"]."</td><td>"
            .$row["productName"]."</td><td>"
            .$row["comments"]."</td></tr>";
    }
    echo "</table></div>";
} else {
    echo "0 results";
}
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
