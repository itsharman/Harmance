<?php

    //configuration
    require("../includes/config.php"); 

	//create new array to store history information
    $history = CS50::query ("SELECT * FROM history WHERE user_id = ?", $_SESSION["id"]);
    
    if (count($history) == 0)
    {
        apologize("No transactions recorded.");
    }
    // dump($history);
    
    //render buy form
    render("history_form.php", ["title" => "History", "history" => $history]);
    
?>