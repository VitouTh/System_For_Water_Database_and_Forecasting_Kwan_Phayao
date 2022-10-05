<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM water_detail ";
if (isset($_POST["search"]["value"])) {
    $query .= 'WHERE date LIKE "%' . $_POST["search"]["value"] . '%" ';
    
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY id ASC ';
}

if ($_POST["length"] != -1) {
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row) {
    $sub_array = array();

    $sub_array[] = $row["id"];
    $sub_array[] = $row["wc"];
    $sub_array[] = $row["av"];
    $sub_array[] = $row["fv"];
    $sub_array[] = $row["fvl"];
    $sub_array[] = $row["fvu"];
    $sub_array[] = $row["date"];                                                                              //https://getbootstrap.com/docs/3.3/components/
    $sub_array[] = '<button type="button" name="update" id="' . $row["id"] . '" class="btn btn-primary btn-sm update">Edit</button>';
    $sub_array[] = '<button type="button" name="delete" id="' . $row["id"] . '" class="btn btn-danger btn-sm delete">Delete</button>';
    $data[] = $sub_array;
}
$output = array(
    "draw"              =>   intval($_POST["draw"]),
    "recordsTotal"      =>   $filtered_rows,
    "recordsFiltered"   =>   get_total_all_records(),
    "data"              =>   $data
);
echo json_encode($output);
