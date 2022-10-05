<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
    if($_POST["operation"] == "Add")
    {
        $statement = $connection->prepare("
            INSERT INTO water_detail (wc, av, fv, fvl, fvu, date) VALUES (:wc, :av, :fv, :fvl, :fvu, :date)");
        $result = $statement->execute(
            array(
                ':wc'    =>   $_POST["wc"],
                ':av'    =>   $_POST["av"],
                ':fv' =>   $_POST["fv"],
                ':fvl' =>   $_POST["fvl"],
                ':fvu' =>   $_POST["fvu"],
                ':date'  =>   $_POST["date"]
            )
        );
    }
    if($_POST["operation"] == "Edit")
    {
        $statement = $connection->prepare(
            "UPDATE water_detail
            SET wc = :wc, av = :av, fv = :fv, fvl = :fvl, fvu = :fvu, date = :date WHERE id = :id");
        $result = $statement->execute(
            array(
                ':wc'    =>   $_POST["wc"],
                ':av'    =>   $_POST["av"],
                ':fv' =>   $_POST["fv"],
                ':fvl' =>   $_POST["fvl"],
                ':fvu' =>   $_POST["fvu"],
                ':date'  =>   $_POST["date"],
                ':id'           =>   $_POST["member_id"]
            )
        );
    }
}
?>