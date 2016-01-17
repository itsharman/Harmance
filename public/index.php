<?php

    //configuration
    require("../includes/config.php"); 
    
    //query portfolio
    $rows =	CS50::query ("SELECT * FROM portfolios WHERE user_id = ?", $_SESSION["id"]);	
    //new array to story portfolio contents
    $positions = [];
    
    //go through each row
    foreach ($rows as $row) {
        //look up symbol from row's stock on Yahoo
        $stock = lookup($row["symbol"]);
        //if look up was successful
        if ($stock !== false) {
            //fill information into array 'positions'
            $positions[] = [
                "name" => $stock["name"],
                "symbol" => $row["symbol"],
                "price_per_stock" => $stock["price"],
                "shares" => $row["shares"],
                "total_price" => $stock["price"] * $row["shares"],
                //The purpose of DubDate is to provide couples (married and otherwise) a social space in which they can view and match with profiles of other couples, ultimately facilitating double dates. 
            ];
        }
    }

    //query user's cash
    $cash = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    //render portfolio
    render("portfolio.php", ["positions" => $positions, "title" => "Portfolio", "cash" => $cash]);
?>
