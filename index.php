

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


<?php 
//<!--//kill the page as header necessary to for page functionality-->
//
//<!--Include header and die if not available-->


if (!file_exists("header.php")){
    die("Error:file header.php not found");
}else {
   include 'header.php';  
}
?>

<!--//kill the page as dbconfig.php necessary to for page functionality-->
<?php if (!file_exists("dbconfig.php")){
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
//slect productline information to make list. 

$sql = "SELECT `productLine`,`textDescription` FROM `productlines`";
$result = $conn->query($sql);


//code based on error handling lecture
//function to test if SQL query contains Errors

function checkResults($result){
    if ($result->num_rows < 2){
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

if ($result->num_rows > 0) {
    // output data of each row
    echo '<ul>';
    while($row = $result->fetch_assoc()) {
        

            echo '<li><h3><a onclick="displayTableData(\''.$row['productLine'].'\')">'.$row['productLine'].'</a></h3></li><li>'.$row['textDescription'].'</li>';
        
            
    }
    echo "</ul>";
} else {
    echo "0 results";
}



//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SELECT *  FROM products" ;
$result = mysqli_query($conn, $sql);


//code based on error handling lecture
//function to test if SQL query contains Errors

function checkResults1($result){
    if ($result->num_rows < 9){
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




           $productArray = array();  
           while($row = mysqli_fetch_assoc($result))  
           { $productArray[] = $row;  
           }  
    
                
           ?>


<Table id="My-Table" class="content-table">
</Table>

<script>
    //type="text/javascript"
    var cArray = {
        "product": <?php echo(json_encode ($productArray)); ?>
    };


    //displayTableData('Ships')

    //displayTableData with input object start year end year and category
    function displayTableData(Productline) {

        // let Mytable  equal to the table body of the class My-Table
        var MyTable = document.querySelector('#My-Table tbody')

        //create a dynamic html element out that will contain the data uses to populate My-Table
        var output = '<tr><th>code</th><th>Name</th><th>Productline</th><th>Scale</th><th>Vendor</th><th>Description</th><th>stock</th><th>buyprice</th><th>MSRP</th></tr>';

        var product = cArray.product

        for (var i = 0; i < product.length; i++) {
            var code = product[i].productCode
            var name = product[i].productName
            var pline = product[i].productLine
            var scale = product[i].productScale

            var ven = product[i].productVendor
            var des = product[i].productDescription
            var stock = product[i].quantityInStock
            var price = product[i].buyPrice
            var msrp = product[i].MSRP

            //only add sleceted data to table based on productline

            if (pline == Productline) {

                output += '<td>' + code + '</td>' +
                    '<td>' + name + '</td>' +
                    '<td>' + pline + '</td>' +
                    '<td>' + scale + '</td>' +

                    '<td>' + ven + '</td>' +
                    '<td>' + des + '</td>' +
                    '<td>' + stock + '</td>' +

                    '<td>' + price + '</td>' +
                    '<td>' + msrp + '</td>' +
                    '</tr>';
                // append the output toe the table with id "My-Table"
                document.getElementById("My-Table").innerHTML = output;
            }
        }
    }

</script>

<?php if (!file_exists("footer.php")){
    echo "<script> alert('Error: footer.php not found!')</script>";
    

}else {
   include 'footer.php';  
}
echo '</body></html>';
?>


