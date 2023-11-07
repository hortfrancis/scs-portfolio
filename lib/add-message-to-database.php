<?php

function addMessageToDatabase(array $message): bool
{
    // Get `$databaseConnection` from `lib/database-connection.php`
    include 'database-connection.php';

    try {
        $pdoStatement = $databaseConnection->prepare('
        INSERT INTO Messages (name, email, phone, message)
        VALUES (:name, :email, :phone, :message)
        ');

        $pdoStatement->bindValue(':name', $message['name'], PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $message['email'], PDO::PARAM_STR);
        $pdoStatement->bindValue(':phone', $message['phone'], PDO::PARAM_STR);
        // If the phone number is an empty string, set it to PHP's `null` instead, 
        // so SQL will save it as it's own `NULL` data type.
        $pdoStatement->bindValue(
            ':phone',
            $message['phone'] === '' ? null : $message['phone'],
            PDO::PARAM_STR
        );
        $pdoStatement->bindValue(':message', $message['message'], PDO::PARAM_STR);

        // Execute the SQL command
        $pdoStatement->execute();

        // If successful, return true for frontend UI feedback
        return true;
    } catch (Exception $exception) {
        echo "Database query failed: " . $exception->getMessage();
        return false;
    }
}
