<?php 
session_start();
require_once '​quiz_data.php';
require_once 'process_answer.php';

if(isset($_POST['Reset'])){
    session_destroy();
    header('Location: index.php');
    exit();
}
if (!isset($_SESSION['index'])) {
    $_SESSION['index'] = 0;
}
if(!isset($_SESSION['quiz_completed'])) {
    $_SESSION['quiz_completed'] = false;
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
if (isset($_POST['answerGiven']) || isset($_POST['returnBack'])) {
    header('Location: process_answer.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pop Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 text-center">

<h1>Pop Quiz</h1>

<?php
if (!$_SESSION['quiz_completed']) {
    echo "<h4>{$_SESSION['quiz_data'][$_SESSION['index']]['question']}</h4>";
} else {
    echo "<h3>Quiz completed! Your score: {$_SESSION['score']} out of " . count($_SESSION['quiz_data']) . "</h3>";
    echo '<form method="post" class="mt-3">
            <button type="submit" name="Reset" value="true" class="btn btn-danger">Restart Quiz</button>
          </form>';
}
?>

<?php if (!$_SESSION['quiz_completed']) { ?>
<form method="post" class="mt-3">

    <?php 
    $options = $_SESSION['quiz_data'][$_SESSION['index']]['options'];
    foreach ($options as $i => $option) {
        if (isset($_SESSION['answers'][$_SESSION['index']]['selected'])) {
            $selected = $_SESSION['answers'][$_SESSION['index']]['selected'];
        } else {
            $selected = -1;
        }
        echo "
        <div class='form-check text-center m-auto w-25'>
            <input class='form-check-input' type='radio' name='radio1' value='$i' " . ($i === $selected ? "checked" : "") . ">
            <label class='form-check-label'>$option</label>
        </div>";
    }
    ?>
    <button type="submit" name="returnBack" value="true" class="btn btn-primary mt-3">Return</button>
    <button type="submit" name="answerGiven" value="true" class="btn btn-primary mt-3">Answer</button>
</form>
<?php } else {
    foreach ($_SESSION['quiz_data'] as $index => $quiz) {
        $user_answer = isset($_SESSION['answers'][$index]['selected']) ? (int)$_SESSION['answers'][$index]['selected'] : -1;
        $correct_answer = (int)$quiz['answer'];
        if($user_answer == $correct_answer){
            $result_class = 'bg-success text-white';
        } else {
            $result_class = 'bg-danger text-white';
        }
        echo "<div class='card mb-3 mt-3' style='max-width: 600px; margin: auto;'>
                <div class='card-body'>
                    <h5 class='card-title $result_class p-3'>Q" . ($index + 1) . ": {$quiz['question']}</h5>";
        foreach ($quiz['options'] as $i => $option) {
            $option_class = '';
            if ($i === $correct_answer) {
                $option_class = 'bg-success text-white';
            } elseif ($user_answer !== -1 && $i === $user_answer && $user_answer !== $correct_answer) {

                $option_class = 'bg-danger text-white';
            }
            echo "<p class='card-text p-2 $option_class'>{$option}</p>";
        }
        echo "</div></div>";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>