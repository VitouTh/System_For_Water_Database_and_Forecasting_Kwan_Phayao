<?php
session_start();
require_once('config/db.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Detail</title>
    <script src="my_chart.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
    <link rel="stylesheet" href="style_index.css">
    <!-- DateRangePicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto align-items-center mt-2">
                <img src="img/ict_tran.png" height="60" width="60">
                <a class="navbar-brand ms-3 " href="Homepage/homepage.html">ระบบฐานข้อมูลและการคาดการ์ปริมาณน้ำกว๊านพะเยา</a>
            </ul>
            <ul class="nav mt-3">
                <li class="nav-item"><a href="Homepage/homepage.html" class="nav-link link-dark px-2 active" aria-current="page">หน้าแรก</a></li>
                <li class="nav-item"><a href="Contract/contract.html" class="nav-link link-dark px-2">ติดต่อ</a></li>
                <li class="nav-item"><a href="About/about.html" class="nav-link link-dark px-2">เกี่ยวกับเรา</a></li>
                <li class="nav-item"><a href="login.php" class="nav-link link-dark px-2">สำหรับแอดมิน</a></li>
            </ul>
        </div>
        </nav>



        <div class="row">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <main class="my-4">


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
                        echo 'No results in DB';
                    }
                } catch (PDOException $e) {
                    die("Error");
                }
                ?>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                ปริมาณน้ำในแต่ละเดือน
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="40" width="100%"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                การเปรียบเทียบปริมาณน้ำและปริมาณน้ำที่คาดการณ์
                            </div>
                            <div class="card-body">
                                <canvas id="myChartLine" height="40" width="100%"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="mb-4">
                        <h4 class="text-center">กราฟแสดงข้อมูลการเปรียบเทียบปริมาณน้ำและปริมาณน้ำที่คาดการณ์</h4>

                        <img src="img/graphforecast.png" height="80%" width="80%" class="mx-auto d-block">
                        <br>
                        <div class="card col-12 col-lg-8 col-xxl-9 mx-auto">
                            <div class="card-body">
                                <p>จุดสีดำในภาพคือ ค่าจริงของปริมาณน้ำ, เส้นสีน้ำเงิน คือผลการวิเคราะห์ข้อมูลการคาดการณ์ปริมาณน้ำ
                                    และส่วนของพื้นที่สีฟ้าคือ ช่วงของข้อมูลการคาดการณ์ปริมาณน้ำระหว่างค่าที่เป็นไปได้ต่ำสุดถึงค่าที่เป็นไปได้สูงสุดในการคาดการณ์ปริมาณน้ำ</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="mb-4">
                        <h4 class="text-center">กราฟแสดงความแปรผันตลอดฤดูกาล</h4>
                        <img src="img/components_year.png" height="80%" width="80%" class="mx-auto d-block">
                        <br>
                        <div class="card col-12 col-lg-8 col-xxl-9 mx-auto">
                            <div class="card-body">
                                <p>กราฟปริมาณน้ำรายปีแสดงปริมาณน้ำในช่วงต้นปีตั้งแต่ มกราคม ถึง กรกฎาคม มีปริมาณที่ลดลงตามระยะเวลา ซึ่งในช่วงนี้จะเป็นช่วงของปลายฤดูหนาว เข้าฤดูร้อน จนถึงต้นฤดูฝน และปริมาณน้ำจะเริ่มเพิ่มขึ้นตั้งแต่เดือนกรกฎาคมจนถึงช่วงเดือนตุลาคมที่ปริมาณน้ำสูงสุด ซึ่งจะสอดคล้องกับเป็นช่วงฤดูฝนของประเทศไทยและจากนั้นเมื่อเข้าฤดูหนาวปริมาณน้ำก็จะลดลงตามลำดับ</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-8 col-xxl-9 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">

                                <h5 class="card-title mb-0">ข้อมูลแหล่งน้ำ</h5>
                            </div>
                            <div class="card-body">

                                <table class="table table-borderless " id="records">
                                    <thead>
                                        <tr>
                                            <th width="2%">ลำดับ</th>
                                            <th width="5%">ความจุน้ำ</th>
                                            <th width="5%">ปริมาณน้ำ</th>
                                            <th width="5%">ปริมาณน้ำ<br>ที่คาดการณ์</th>
                                            <th width="5%">ปริมาณน้ำ<br>ที่คาดการณ์<br>ต่ำสุด</th>
                                            <th width="5%">ปริมาณน้ำ<br>ที่คาดการณ์<br>สูงสุด</th>
                                            <th width="5%">วันที่</th>


                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 col-xxl-3 ">
                        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">ค้นหา</h5>
                            </div>
                            <div class="card-body ">
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" id="start_date" placeholder="Start Date">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control" id="end_date" placeholder="End Date">
                                </div>
                                <div>
                                    <button id="filter" class="btn btn-outline-info btn-sm">ค้นหา</button>
                                    <button id="reset" class="btn btn-outline-warning btn-sm">รีเซ็ต</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <!-- Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js">
    </script>
    <!-- Momentjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
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

    <script>
        $(function() {
            $("#start_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
            });
            $("#end_date").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
            });
        });
    </script>

    <script>
        // Fetch records

        function fetch(start_date, end_date) {
            $.ajax({
                url: "records.php",
                type: "POST",
                data: {
                    start_date: start_date,
                    end_date: end_date
                },
                dataType: "json",
                success: function(data) {
                    // Datatables
                    var i = "1";

                    $('#records').DataTable({
                        "data": data,
                        // buttons
                        "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        "buttons": [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        "columns": [{
                                "data": "id",
                                "render": function(data, type, row, meta) {
                                    return i++;
                                }
                            },
                            {
                                "data": "wc"
                            },
                            {
                                "data": "av",
                                // "render": function(data, type, row, meta) {
                                //     return `${row.standard}th Standard`;
                                // }
                            },
                            {
                                "data": "fv",
                                // "render": function(data, type, row, meta) {
                                //     return `${row.percentage}%`;
                                // }
                            },
                            {
                                "data": "fvl",
                                // "render": function(data, type, row, meta) {
                                //     return `${row.percentage}%`;
                                // }
                            },
                            {
                                "data": "fvu",
                                // "render": function(data, type, row, meta) {
                                //     return `${row.percentage}%`;
                                // }
                            },

                            {
                                "data": "date",
                                "render": function(data, type, row, meta) {
                                    return moment(row.date).format('DD-MM-YYYY');
                                }
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        // Filter

        $(document).on("click", "#filter", function(e) {
            e.preventDefault();

            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            if (start_date == "" || end_date == "") {
                alert("both date required");
            } else {
                $('#records').DataTable().destroy();
                fetch(start_date, end_date);
            }
        });

        // Reset

        $(document).on("click", "#reset", function(e) {
            e.preventDefault();

            $("#start_date").val(''); // empty value
            $("#end_date").val('');

            $('#records').DataTable().destroy();
            fetch();
        });
    </script>
</body>

</html>