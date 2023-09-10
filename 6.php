<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook</title>
</head>
<body>
    <h1>Guestbook</h1>

    <?php
    // Define a function to display error messages
    function displayError($message) {
        echo "<p style='color: red;'>Error: $message</p>";
    }

    // Initialize variables
    $name = "";
    $message = "";
    $entries = [];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $message = $_POST["message"];

        // Validate input
        if (empty($name)) {
            displayError("Please enter your name.");
        } elseif (empty($message)) {
            displayError("Please enter a message.");
        } else {
            // Save the entry to a text file
            $entry = "$name: $message\n";
            file_put_contents("guestbook.txt", $entry, FILE_APPEND);
        }
    }

    // Read and display guestbook entries
    if (file_exists("guestbook.txt")) {
        $entries = file("guestbook.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!empty($entries)) {
            echo "<h2>Guestbook Entries</h2>";
            echo "<ul>";
            foreach ($entries as $entry) {
                echo "<li>" . htmlspecialchars($entry) . "</li>";
            }
            echo "</ul>";
        }
    }
    ?>

    <h2>Add an Entry</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message"><?php echo htmlspecialchars($message); ?></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
