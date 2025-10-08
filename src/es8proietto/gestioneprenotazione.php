<?php
    $camerieri = ["Mario", "Luigi", "Peach", "Toad", "Yoshi"];
  
    $order = [
        "name" => $_POST["name"],
        "surname" => $_POST["surname"],
        "table" => $_POST["table"],
        "time" => $_POST["time"],
        "notes" => $_POST["notes"],
        "appetizer" => isset($_POST["appetizer"]) ? "Yes" : "No",
        "main" => isset($_POST["main"]) ? "Yes" : "No",
        "second" => isset($_POST["second"]) ? "Yes" : "No",
        "waiter" => $camerieri[array_rand($camerieri)],
        "parking" => isset($_POST["parking"]) ? $_POST["parking"]: "none",
        "price" => calcCost(),
    ];

    function calcCost() {
        $cost = 0;
        if (isset($_POST["appetizer"])) $cost += 5;
        if (isset($_POST["main"])) $cost += 6;
        if (isset($_POST["second"])) $cost += 7;

        if(isset($_POST["appetizer"]) && !isset($_POST["main"]) && !isset($_POST["second"])){
            header("Location: prenotazione.php?error=You must select at least a main course or a second course if you choose an appetizer");
            exit();         
        }
        if(!isset($_POST["appetizer"]) && !isset($_POST["main"]) && !isset($_POST["second"])){
            header("Location: prenotazione.php?error=You must select at least a main course or a second course or an appetizer");
            exit();         
        }
        if(isset($_POST["main"]) && isset($_POST["second"])){
            if(isset($_POST["appetizer"]) && isset($_POST["main"]) && isset($_POST["second"])){
                $cost *=0.9;//10% discount;
            }else{
                $cost *=0.85;// 15% discount;
            }
        }  

        if(isset($_POST["parking"])){
            if($_POST["parking"] == "non-custodito"){
                $cost += 3;
            }else if($_POST["parking"] == "custodito"){
                $cost += 5;
            }
        }

        return $cost;
    }

    function printOrder($order) {
        echo '<div class="container mt-5 text-center">';
        echo '<div class="card shadow">';
        echo '<div class="card-header bg-primary text-white text-center">';
        echo '<h2>Order Summary</h2>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<ul class="list-group list-group-flush">';
        foreach ($order as $key => $value) {
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
            echo '<span class="fw-bold">' . ucfirst($key) . ':</span>';
            echo '<span>' .$value . '</span>';
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    printOrder($order);


?>