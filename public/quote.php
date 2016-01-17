<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render quote_form
        render("quote_form.php", ["title" => "Quote"]);
    }
    
    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //look up stock symbol on Yahoo (if inputted and valid)
        if (!empty($_POST["symbol"])) {
            $stock = lookup($_POST["symbol"]);
            if ($stock === false) {
                apologize("Please provide a valid stock symbol.");
            }
        }
        
        //if not inputted, ask for stock symbol
        else {
            apologize("Please provide the stock symbol");
            return false;
        }
  
        //render results form
        render("quote_results.php", ["title" => "Quote", "symbol" => $stock["symbol"], "name" => $stock["name"], "price" => $stock["price"]]);
    }
    
?>
