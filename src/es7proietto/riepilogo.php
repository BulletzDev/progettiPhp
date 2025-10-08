<?php include "./headTemplate.php"; 
    if(isset($_GET["name"]) && isset($_GET["surname"]) && isset($_GET["email"])) {
        $name = $_GET["name"];
        $surname = $_GET["surname"];
        $email = $_GET["email"];
        echo "<h1 class='text-center'>Dati inviati</h1>";
        echo "<table class='table table-striped w-50 m-auto'>
                <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>Surname</th>
                        <th scope='col'>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>$name</td>
                        <td>$surname</td>
                        <td>$email</td>
                    </tr>
                </tbody>
            </table>";
    } else {
        echo "<h1 class='text-center'>Errore: Dati mancanti</h1>";
    }
include "bottomTemplate.php"; ?>