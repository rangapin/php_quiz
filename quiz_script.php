<?php
session_start();

include('quiz_questions.php');

$currentIndex = isset($_SESSION['current_index']) ? $_SESSION['current_index'] : 0;
$userAnswers = isset($_SESSION['user_answers']) ? $_SESSION['user_answers'] : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswer = isset($_POST['user_answer']) ? $_POST['user_answer'] : null;

    // Add your answer processing logic here
    if ($userAnswer !== null) {
        $userAnswers[$currentIndex] = $userAnswer;
    }

    $currentIndex++;

    if ($currentIndex >= count($phpQuiz)) {
        // Quiz Completed! Calculate and display the score
        $score = 0;
        foreach ($userAnswers as $index => $answer) {
            $correctAnswer = $phpQuiz[array_keys($phpQuiz)[$index]]['correct'];
            if ($answer === $correctAnswer) {
                $score++;
            }
        }

        echo "Your Score: $score out of " . count($phpQuiz);
        echo "<br>";
        echo "<a href='index.php'>Back to Home</a>";

        // Unset session variables and end the script
        unset($_SESSION['current_index']);
        unset($_SESSION['user_answers']);
        exit;
    } else {
        $_SESSION['current_index'] = $currentIndex;
    }
}

$currentQuestion = array_keys($phpQuiz)[$currentIndex];
$options = $phpQuiz[$currentQuestion];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Quiz</title>
</head>
<body>

    <h1>PHP Quiz</h1>

    <form method="post" action="">
        <h2><?= $currentQuestion ?></h2>
        
        <?php foreach ($options as $option => $value): ?>
            <label>
                <input type="radio" name="user_answer" value="<?= $option ?>" required>
                <?= $value ?>
            </label><br>
        <?php endforeach; ?>

        <button type="submit">Next Question</button>
    </form>

    <br>
    <a href="index.php">Back to Home</a>

</body>
</html>







