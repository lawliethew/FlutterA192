<?php
error_reporting(0);
include_once ("dbconnect.php");
$email = $_POST['email'];
$prodid = $_POST['proid'];
$userquantity = $_POST['quantity'];
$status = "notpaid";

$sqlquantity = "SELECT * FROM CART WHERE EMAIL = '$email' AND STATUS = '$status'";

$resultq = $conn->query($sqlquantity);
if ($resultq->num_rows > 0) {
    $quantity = 0;
    while ($row = $resultq ->fetch_assoc()){
        $quantity = $row["CQUANTITY"] + $quantity;
    }
}

$sqlsearch = "SELECT * FROM CART WHERE EMAIL = '$email' AND PRODID= '$prodid'";

$result = $conn->query($sqlsearch);
if ($result->num_rows > 0) {
    while ($row = $result ->fetch_assoc()){
        $prquantity = $row["CQUANTITY"];
    }
    $prquantity = $prquantity + $userquantity;
    $sqlinsert = "UPDATE CART SET CQUANTITY = '$prquantity' WHERE PRODID = '$prodid' AND EMAIL = '$email'";
    
}else{
    $sqlinsert = "INSERT INTO CART(EMAIL,PRODID,CQUANTITY,STATUS) VALUES ('$email','$prodid',$userquantity,'$status')";
}

if ($conn->query($sqlinsert) === true)
{
    $quantity = $quantity +1;
    echo "success,".$quantity;
}
else
{
    echo "failed";
}

?>