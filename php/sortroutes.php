<?php

    require_once('config.php');

    $out = "";
    $ord = $_POST["order"];

    $sql = "
    
        SELECT name, ship_id, trade_dep, trade_arr, dep_exp, arr_exp
            FROM ships JOIN routes
            ORDER BY " . $_POST["column"] . " " . $_POST["order"] . " 
        
        ";

    if(!($result = $connection->query($sql)))
        die('<script>alert("Errore nella richiesta di ordinamento.")</script>');

    if ($ord == "desc")
        $ord = "asc";
    else
        $ord = "desc";

    $out .= '
        <table class="table border">
            <thead class="table-light fw-semibold">
                <tr class="align-middle">
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="name" data-order="' . $ord . '">Nave</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="trade_dep" data-order="' . $ord . '">Partenza</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="trade_arr" data-order="' . $ord . '">Arrivo</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="dep_exp" data-order="' . $ord . '">Data partenza prev.</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="arr_exp" data-order="' . $ord . '">Data arrivo prev.</a></th>
                     <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="dep_eff" data-order="asc">Data partenza eff.</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="arr_eff" data-order="asc">Data arrivo eff.</a></th>
                    <th class="text-center"></th>
                    <th class="text-end"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>     
    ';

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if(!$row["dep_eff"])
            $row["dep_eff"] = '/';
        if(!$row["arr_eff"])
            $row["arr_eff"] = '/';
        $out .= '
        
            <tr class="align-middle" id="' . $row["ship_id"] . '-' . $row["dep_exp"] . '">
                <td class="text-center">
                    <div>' . $row["name"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                    <div>' . $row["trade_dep"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                    <div>' . $row["trade_arr"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                   <div>' . $row["dep_exp"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                    <div>' . $row["arr_exp"] . '</div>
                </td>
                <td class="text-center" style="padding: 20px">
                    <div>' . $row["dep_eff"] . '</div>
                </td>
                <td class="text-center" style="padding: 20px">
                    <div>' . $row["arr_eff"] . '</div>
                </td>
                <td>
                <form method="GET" class="">
                    <a href="php/editemployee.php?id=' . $row["ship_id"] . '-' . $row["dep_exp"] . '" class="btn btn-primary m-1"><i class="cil-pen"></i></a>
                    <a href="#" class="btn btn-danger m-1 deleteButton"><i class="cil-trash"></i></a>
                </form>
                </td>
            </tr>
        
        ';
    }

    $out .= '</tbody></table>';

    echo $out;
?>