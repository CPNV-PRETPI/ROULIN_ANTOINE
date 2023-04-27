<?php
/**
 * @file        dashboard.php
 * @brief       This file is design to be the contact page of the web app
 * @author      Created by Antoine.ROULIN
 * @version     13.03.23
 */
$title = "BudgetPlanner - Home";

ob_start()
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Home</h1>
    </div>
</main>

<?php
$content = ob_get_clean();  
require "gabarit.php";
?>

