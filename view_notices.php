<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notices</title>
    <link rel="stylesheet" href="home.css">
    <style>
        body {
            background-image: url("BB-Hall_01.jpeg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .container {
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background for readability */
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .notice {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly opaque background for notices */
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 800px;
            color: #333;
        }
        h1.title {
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .button {
            text-decoration: none;
            padding: 10px 15px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        h2 {
            color: #0056b3;
        }
        p {
            font-size: 1.2rem;
        }
        hr {
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="title">Khulna University Students Hall</h1>
    <a href="index.html" class="button">Home</a>
    <a href="view_notices.php" class="button">Noticeboard</a>
    <a href="login.html" class="button">Login</a>
    <a href="studentlogin.html" class="button">Registration</a>
</div>

<div class="notice">
    <?php
    // Include the database configuration
    include 'db_config.php'; // Centralized database connection

    // SQL query to get all notices
    $sql = "SELECT * FROM notices ORDER BY created_at DESC"; // Get notices in descending order by creation date

    // Execute the query
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Loop through each notice and display it
        while($row = $result->fetch_assoc()) {
            echo '<h2>Title: ' . htmlspecialchars($row["title"]) . '</h2>';
            echo '<p>Content: ' . nl2br(htmlspecialchars($row["content"])) . '</p>';
            echo "<p>Created At: " . $row["created_at"] . "</p><hr>";
        }
    } else {
        echo "<p>No notices found.</p>"; // Display message if no results found
    }

    // Close the connection
    $conn->close();
    ?>
</div>

</body>
</html>
