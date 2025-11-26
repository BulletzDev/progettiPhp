<?php
if (isset($_POST['answerGiven'])) {
    $selected_option = isset($_POST['radio1']) ? (int)$_POST['radio1'] : -1;
    $_SESSION['answers'][$_SESSION['index']]['selected'] = $selected_option;
    $_SESSION['index']++;
    if ($_SESSION['index'] >= count($_SESSION['quiz_data'])) {
        $_SESSION['quiz_completed'] = true;
        foreach ($_SESSION['answers'] as $k => $v) {
            if ($v['selected'] === $_SESSION['quiz_data'][$k]['answer']) {
                $_SESSION['score']++;
            }

        }
        header('Location: index.php');
        exit();
    }
    header('Location: index.php');
    exit();
}

if (isset($_POST['returnBack'])) {
    $selected_option = isset($_POST['radio1']) ? (int)$_POST['radio1'] : -1;
    $_SESSION['answers'][$_SESSION['index']]['selected'] = $selected_option ;
    $_SESSION['index']--;
    header('Location: index.php');
    exit();
}
