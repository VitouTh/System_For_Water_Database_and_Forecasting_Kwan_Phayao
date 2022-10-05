<?php

session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header('Location: login.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminDashboard</title>
    <script src="my_chart.js"></script>
    <link rel="stylesheet" href="style_admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
    <!-- DateRangePicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_SESSION['admin_login'])) {
        $user_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * FROM users WHERE id = '$user_id'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>


    <div class="container-fluid m-0 p-0">

        <div class="row ">
            <nav id="sidebar" class="col-md-2 col-lg-2 d-md-block  sidebar collapse m-0 p-0 text-light">
                <aside>
                    <div class="sidebar">
                        <br>
                        <h2 class="text-center">Admin Dashboard</h2>
                        
                        <h2 class="text-center">ยินดีต้อนรับ <?php echo $row['username'] ?></h2>
                        <a href="admin_dashboard.php">
                            <span class="material-icons-sharp">dashboard</span>
                            <h3>Dashboard</h3>
                        </a>
                        <a href="admin_table.php">
                            <span class="material-icons-sharp">receipt_long</span>
                            <h3>Table</h3>
                        </a> <a href="admin_chart.php">
                            <span class="material-icons-sharp">insights</span>
                            <h3>Chart</h3>
                        </a>
                        </a> <a href="logout.php">
                            <span class="material-icons-sharp">logout</span>
                            <h3>Logout</h3>
                        </a>
                    </div>
                </aside>
            </nav>
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <h1 class="h2">Table</h1>
                
                <?php
                try {
                    $sql = "SELECT * FROM ( SELECT * FROM water_detail ORDER BY id DESC LIMIT 12)Var1 ORDER BY id ASC;";
                    $result = $conn->query($sql);
                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch()) {
                            $dateArray[] = $row["date"];
                            $avArray[] = $row["av"];
                            $fvArray[] = $row["fv"];
                            $fvlArray[] = $row["fvl"];
                            $fvuArray[] = $row["fvu"];
                        }
                        unset($result);
                    } else {
                        echo 'ไม่มีข้อมูล';
                    }
                } catch (PDOException $e) {
                    die("Error");
                }
                ?>
                <div class="row">
                    <div class="col-12 col-lg-8 col-xxl-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <div class="btn-group d-flex justify-content-between">
                                    <h5 class="mt-2 card-title mb-0">ตารางแสดงข้อมูล</h5>
                                    <div>
                                        <button type="button" id="add_button" data-bs-toggle="modal" data-bs-target="#userModal" class="btn btn-success ">เพิ่มข้อมูล</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless  " id="member_table">
                                    <thead>
                                        <tr align="center">
                                            <th width="2%">ลำดับ</th>
                                            <th width="5%">ความจุน้ำ</th>
                                            <th width="5%">ปริมาณน้ำ</th>
                                            <th width="5%" >ปริมาณน้ำ<br>ที่คาดการณ์</th>
                                            <th width="5%" >ปริมาณน้ำ<br>ที่คาดการณ์<br>ต่ำสุด</th>
                                            <th width="5%" >ปริมาณน้ำ<br>ที่คาดการณ์<br>สูงสุด</th>
                                            <th width="5%">วันที่</th>
                                            <th scope="col" width="5%">แก้ไข</th>
                                            <th scope="col" width="5%">ลบ</th>

                                        </tr>
                                    </thead>
                                    <tbody align="center"></tbody>
                                </table>
                                </br>

                            </div>
                            <div class="col-3"></div>
                        </div>
                        <div id="userModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="post" id="member_form" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h4 class="modal-title">เพิ่มข้อมูล</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label>ความจุน้ำ</label>
                                            <input type="text" name="wc" id="wc" class="form-control" />
                                            <br />
                                            <label>ปริมาณน้ำ</label>
                                            <input type="text" name="av" id="av" class="form-control" />
                                            <br />
                                            <label>ปริมาณน้ำที่คาดการณ์</label>
                                            <input type="text" name="fv" id="fv" class="form-control" />
                                            <br />
                                            <label>ปริมาณน้ำที่คาดการณ์ต่ำสุด</label>
                                            <input type="text" name="fvl" id="fvl" class="form-control" />
                                            <br />
                                            <label>ปริมาณน้ำที่คาดการณ์สูงสุด</label>
                                            <input type="text" name="fvu" id="fvu" class="form-control" />
                                            <br />
                                            <label>วันที่</label>
                                            <input type="text" name="date" id="date" class="form-control" />
                                            <br />
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="member_id" id="member_id" />
                                            <input type="hidden" name="operation" id="operation" />
                                            <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // setup 
        const data = {
            labels: <?php echo json_encode($dateArray) ?>,
            datasets: [{
                label: 'ปริมาณน้ำ',
                data: <?php echo json_encode($avArray) ?>,
                backgroundColor: [
                    
                    'rgba(54, 162, 235, 0.2)',
                    
                ],
                borderColor: [
                    
                    'rgba(54, 162, 235, 1)',
                    
                ],
                borderWidth: 1
            }]
        };

        // config 
        const config = {
            type: 'bar',
            data,
            options: {
                scales: {

                    y: {
                        beginAtZero: true,

                    }
                }
            }

        };
        // render init block
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );




        const dataLine = {
            labels: <?php echo json_encode($dateArray) ?>,
            datasets: [{
                label: 'ปริมาณน้ำ',
                data: <?php echo json_encode($avArray) ?>,
                backgroundColor: [
                    
                    'rgba(54, 162, 235, 0.2)',
            
                ],
                borderColor: [
                    
                    'rgba(54, 162, 235, 1)',
                    
                ],
                borderWidth: 1
            }, {
                label: 'ปริมาณน้ำที่คาดการณ์',
                data: <?php echo json_encode($fvArray) ?>,
                backgroundColor: [
                    'rgba(255, 26, 104, 0.2)',
                    
                ],
                borderColor: [
                    'rgba(255, 26, 104, 1)',
                    
                ],
                borderWidth: 1
            }]
        };

        // config 
        const configLine = {
            type: 'line',
            data: dataLine,
            options: {

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // render init block
        const myChartLine = new Chart(
            document.getElementById('myChartLine'),
            configLine
        );
    </script>

    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $('#add_button').click(function() {
                $('#member_form')[0].reset();
                $('.modal-title').text("เพิ่มข้อมูล");
                $('#action').val("Add");
                $('#operation').val("Add");
            });

            $(document).ready(function() {
                $('#member_table').DataTable();
            });
            var dataTable = $('#member_table').DataTable({
                "paging": true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "info": true,
                "ajax": {
                    url: "fetch.php",
                    type: "POST"
                },
                "columnDefs": [{
                    "targets": [0, 3, 4],
                    "orderable": false,
                }, ],
            });

            $(document).on('submit', '#member_form', function(event) {
                event.preventDefault();
                var id = $('#id').val();
                var wc = $('#wc').val();
                var av = $('#av').val();
                var fv = $('#fv').val();
                var fvl = $('#fvl').val();
                var fvu = $('#fvu').val();
                var date = $('#date').val();

                if (wc != '' && av != '' && fv != '' && date != '') {
                    $.ajax({
                        url: "insert.php",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#member_form')[0].reset();
                            $('#userModal').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
                } else {
                    alert("กรุณาป้อนข้อมูล");
                }
            });

            $(document).on('click', '.update', function() {
                var member_id = $(this).attr("id");

                $.ajax({
                    url: "fetch_single.php",
                    method: "POST",
                    data: {
                        member_id: member_id
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#userModal').modal('show');
                        $('#id').val(data.id);
                        $('#wc').val(data.wc);
                        $('#av').val(data.av);
                        $('#fv').val(data.fv);
                        $('#fvl').val(data.fvl);
                        $('#fvu').val(data.fvu);
                        $('#date').val(data.date);
                        $('.modal-title').text("แก้ไขข้อมูล");
                        $('#member_id').val(member_id);
                        $('#action').val("Save");
                        $('#operation').val("Edit");
                    }
                })
            });

            $(document).on('click', '.delete', function() {
                var member_id = $(this).attr("id");
                if (confirm("คุณต้องการลบข้อมูลนี้หรือไม่")) {
                    $.ajax({
                        url: "delete.php",
                        method: "POST",
                        data: {
                            member_id: member_id
                        },
                        success: function(data) {
                            dataTable.ajax.reload();
                        }
                    });
                } else {
                    return false;
                }
            });


        });
    </script>
    <script src="main.js"></script>
</body>

</html>