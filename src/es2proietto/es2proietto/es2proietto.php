<?php
function is_palindrome($str)
{
    return $str == strrev($str) ? "palindorma" : "non palindroma";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="es2proietto.php" method="get">
        <label for="str1">Insert String:</label>
        <input type="text" id="str1" name="str1"><br><br>
        <input type="submit" value="">
    </form>
    <?php
    if (isset($_GET['str1']) && $_GET['str1'] !== "") {
        $input = $_GET['str1'];
        $input_sv = preg_replace('/[aeiouAEIOUàèéìòùÀÈÉÌÒÙ]/', '', $input);
        echo '<p>la stringa ' . htmlspecialchars($input) . ' è ' . is_palindrome($input) . '</p>';
        echo '<p>la stringa ' . htmlspecialchars($input) . ' senza vocali è ' . htmlspecialchars($input_sv) . '</p>';
    } else {
        echo "<p>Inserisci una stringa</p>";
    }
    ?>
</body>

</html>