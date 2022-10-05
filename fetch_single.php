<?php
include('db.php');
include('function.php');
if(isset($_POST["member_id"]))
{
    $output = array();
    $statement = $connection->prepare(
        "SELECT * FROM water_detail WHERE id = '".$_POST["member_id"]."' LIMIT 1"
    );
    $statement->execute();
    $result = $statement->fetchAll();
    foreach($result as $row)
    {
        $output["id"] = $row["id"];
        $output["wc"] = $row["wc"];
        $output["av"] = $row["av"];
        $output["fv"] = $row["fv"];
        $output["fvl"] = $row["fvl"];
        $output["fvu"] = $row["fvu"];
        $output["date"] = $row["date"];
    }
    echo json_encode($output);
}
?>