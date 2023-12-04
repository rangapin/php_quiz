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
        echo "<a href='index.php' class='text-blue-500'>Back to Home</a>";

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
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body class="bg-gray-200">

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">PHP Quiz</h1>

        <form method="post" action="" class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2"><?= $currentQuestion ?></h2>

            <?php foreach ($options as $option => $value): ?>
                <label class="block mb-2">
                    <input type="radio" name="user_answer" value="<?= $option ?>" required class="mr-2">
                    <?= $value ?>
                </label>
            <?php endforeach; ?>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Next Question</button>
        </form>

        <br>
        <a href="index.php" class="text-blue-500">Back to Home</a>
    </div>

</body>
</html>








