<?php
// Retrieve data from the POST request
$posttitle = isset($_POST['posttitle']) ? $_POST['posttitle'] : 'No Title';
$postdescription = isset($_POST['postdescription']) ? $_POST['postdescription'] : 'No Description';
$category = isset($_POST['category']) ? $_POST['category'] : 'Uncategorized';

// You can add more fields here depending on your form inputs.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: <?php echo htmlspecialchars($posttitle); ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS for styling -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .article-container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .article-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .article-header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .article-header h2 {
            font-size: 20px;
            color: #888;
        }

        .article-body {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
            margin-top: 20px;
        }

        .article-footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #aaa;
        }

        .article-body p {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="article-container">
        <div class="article-header">
            <h1><?php echo htmlspecialchars($posttitle); ?></h1>
            <h2>Category: <?php echo htmlspecialchars($category); ?></h2>
        </div>

        <div class="article-body">
            <p><?php echo nl2br(htmlspecialchars($postdescription)); ?></p>
        </div>

        <div class="article-footer">
            <p>Posted on: <?php echo date("F j, Y"); ?></p>
        </div>
    </div>

</body>
</html>
