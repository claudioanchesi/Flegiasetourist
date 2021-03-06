<?php


    require_once('config.php');

    /**@var mysqli $connection*/

    $tradeDep = $_GET['trade_dep']; //Porto di partenza
    $tradeArr = $_GET['trade_arr']; //Porto di arrivo
    $depExp = $_GET['dep_exp'];     //Data di partenza prevista

    // Query che seleziona le rotte non annullate, che non sono partite,
    // e successive alla data odierna, relative ad una rotta
    $sql = "

        SELECT dep_exp, arr_exp, ship_id, price_adult, price_underage, num_pass, routes.id
            FROM routes JOIN trades 
                ON trade_id = trades.id
            WHERE 
                harb_dep = '$tradeDep' AND harb_arr = '$tradeArr' 
                AND
                dep_exp >= '$depExp' AND dep_eff IS NULL AND NOT routes.deleted
            ORDER BY dep_exp ASC
                
    ";

    $out = '
        <div class="mb-4"></div>
        <table class="table border" id="routes">
            <thead class="table-light fw-semibold">
                <th class="">Tratta</th>
                <th class="">Data partenza</th>
                <th class="">Data arrivo</th>
                <th class="">Prezzi</th>
                <th class="">Posti rimanenti</th>
                <th></th>
            
    ';
    if ($result = $connection->query($sql)) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!$row)
            $out .= '</thead></table><div class="text-center">Nessuna rotta programmata</div>';
        else {
            $rem = '200'-$row['num_pass'];
            $out .= "</thead><tbody>";
            while ($row) {
                $out .= "
                
                    <tr id='". $row['id'] ."'>
                        <td>$tradeDep - $tradeArr</td>
                        <td>" . date("d/m/Y H:i", strtotime($row['dep_exp'])) . "</td>
                        <td>" . date("d/m/Y H:i", strtotime($row['arr_exp'])) . "</td>
                        <td>Adulto:\t€" . number_format((float)$row['price_adult'], 2) . "<br>Ragazzo:\t€" . number_format((float)$row['price_underage'], 2) . "</td>
                        <td>" . $rem . "</td>
                
                ";

                if($_SESSION['type'] === 'cliente' && isset($_SESSION['type']))
                    $out .= "<td class='text-center'><button class='btn btn-warning mt-1 reservationModalBtn'>Prenota</button></td>";
                else
                    $out .= "<td class='text-center'><div class='badge bg-warning text-dark'>Accedi per prenotare</div></td>";


                $row = $result->fetch_array(MYSQLI_ASSOC);
            }
            $out .= "</tr></tbody></table>";
        }
    }

    echo $out;
