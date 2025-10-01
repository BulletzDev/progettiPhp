<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php echo "<ul>";
    $tot = 1;
    $n = 2;
    function is_prime($n)
    {
        for ($i = 2; $i < $n; $i++) {
            if ($n % $i == 0) {
                return 0;
            }
        }
        return $n;
    }

    while ($tot <= 100) {
        $prime = is_prime($n);
        if ($prime != 0) {
            echo "<li>il $tot numero primo è: $prime<li>";
            $tot++;
        }
        $n++;

    }
    echo "</ul>"
        ?>

</body>

</html>