<?php
require_once('php/config.php');

session_start();

if (!isset($_SESSION['id']))
    header("location: login.php");
else if ($_SESSION['type'] === 'capitano')
    header('location: dashboard.php');
else if ($_SESSION['type'] === 'cliente')
    header('location: index.php');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/img/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/180.png">

    <!-- Style -->
    <link href="https://coreui.io/demo/4.0/free/css/style.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="src/jquery/jquery.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <title>Clienti</title>
</head>
<body>


<!-- Begin Sidebar -->
<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-md-flex">
        <button class="header-toggler px-md-0 me-md-3" type="button"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <span class="text-light fs-3">Menu</span>
        </button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="cil-speedometer nav-icon"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="routes.php">
                <i class="cil-compass nav-icon"></i>
                Rotte
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="employees.php">
                <i class="cil-contact nav-icon "></i>
                Dipendenti
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ships.php">
                <i class="cil-boat-alt nav-icon"></i>
                Navi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="clients.php">
                <i class="cil-user nav-icon"></i>
                Clienti
            </a>
        </li>

    </ul>
    <button class="sidebar-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle(); "></button>
</div>
<!--End Sidebar-->


<div class="wrapper d-flex flex-column min-vh-100 bg-light">


    <!-- Begin Header -->
    <header class="header header-sticky mb-4">
        <div class="container-fluid">
            <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <i class="icon icon-lg cil-menu"></i>
            </button>

            <span class="fs-4">Flegias & Tourist</span>

            <a href="logout.php" class="btn btn-light">Esci</a>
        </div>
        <div class="header-divider"></div>
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <li class="breadcrumb-item"><span>Clienti</span></li>
                </ol>
            </nav>
        </div>
    </header>
    <!-- End Header -->


    <!--Begin Content -->
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">

            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-header"><span class="fs-2">Clienti</span></div>

                        <div class="card-body">
                            <div class=" d-flex flex-row-reverse">
                                <div class="m-2"></div>

                                <div class="lg-col-2">
                                    <input class="form-control m-2 me-1" id="searchInput" onkeyup="searchElements()"
                                           type="text"
                                           placeholder="Cerca">
                                </div>

                            </div>
                            <div class="table-responsive" id="warehouseTable">
                                <table class="table border">
                                    <thead class="table-light fw-semibold">
                                        <tr class="align-middle">
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="id_code" data-order="asc">ID</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="surname" data-order="asc">Cognome</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="name" data-order="asc">Nome</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="email" data-order="asc">Email</a></th>
                                            <th class="text-center"></th>
                                            <th class="text-center"></th>
                                            <th class="text-end"></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    $sql = "
                                        
                                        SELECT id_code, surname, name, email
                                            FROM users
                                            WHERE type = 'cliente'
                                    
                                    ";

                                    if ($result = $connection->query($sql)) {

                                        while ($row = $result->fetch_array()) {
                                            echo '
                                                <tr class="align-middle" id="' . $row["id_code"] . '">
                                                    <td class="text-center">
                                                        <div>' . $row["id_code"] . '</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div>' . $row["surname"] . '</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div>' . $row["name"] . '</div>
                                                    </td>
                                                    <td class="text-center">
                                                       <div>' . $row["email"] . '</div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <form method="GET" class="">
                                                            <a href="php/editclient.php?id=' . $row['id_code'] . '" class="btn btn-primary m-1"><i class="cil-pen"></i></a>
                                                            <a href="#" class="btn btn-danger m-1 deleteButton"><i class="cil-trash"></i></a>
                                                        </form>
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
    <!--End Content -->
    <!--End Content -->

    <!--Begin Footer -->
    <footer class="footer">
        <div class="">Flegias & Tourist
        </div>
        <div class="ms-auto">Danny De Novi & Claudio Anchesi © 2022</div>
    </footer>
    <!-- End Footer -->
</div>
</body>


<script>

    function searchElements() {
        // Declare variables
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("warehouseTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];

            if (td) {
                txtValue = td.textContent || td.innerText;


                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    $('.deleteButton').click(function(){
        var tr = $(this).closest('tr'),
            del_id = $(tr).attr('id');

        $.ajax({
            method: 'GET',
            url: "php/deleteuser.php?id="+ del_id,
            cache: false,
            success:function(result){
                tr.fadeOut(1000, function(){
                    $(this).remove();
                });
            }
        });
    });

    $(document).on("click", ".orderButton", function () {
        var column = $(this).attr("id"),
            order = $(this).data("order");

        $.ajax({
            url: "php/sortclient.php",
            method: "POST",
            data: {column: column, order: order},
            success: function (data) {
                $('#warehouseTable').html(data);
            }
        });
    });

</script>


</html>