<?php
if (isset($_POST['answerGiven'])) {
    $selected_option = intval($_POST['radio1']); 
    $correct_answer = intval($_SESSION['quiz_data'][$_SESSION['index']]['answer']);
    if ($selected_option === $correct_answer) {
        $_SESSION['score']++;
        $_SESSION['index']++;
    }
    $_SESSION['index']++;
    if ($_SESSION['index'] >= count($_SESSION['quiz_data'])) {
        $_SESSION['quiz_completed'] = true;
        header('Location: index.php');
        exit();
    }
    header('Location: index.php');
    exit();
}