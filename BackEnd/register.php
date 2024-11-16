<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $host = "localhost";
    $dbname = "E_Commerce";
    $username_db = "root";
    $password_db = "";
    try {
        $db = new PDO(
            "mysql:host=$host;dbname=$dbname",
            $username_db, $password_db
        );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare(
            "INSERT INTO users (name,username,email, password)
                VALUES (:name, :username, :email,:password)"
        );
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->execute();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registration Page</title>
            <style>
                .success-message {
                    background-color: #4CAF50;
                    color: white;
                    border-radius: 8px;
                    padding: 20px;
                    text-align: center;
                    margin-top: 20px;
                }

                .success-message h2 {
                    margin-top: 0;
                }

                .success-message p {
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <div class="success-message">
                <h2>Registration Successful</h2>
                <p>Thank you for registering, <?php echo $name; ?>!</p>
                <p>You will be redirected to the login page shortly.</p>
            </div>
            <?php
            header("refresh:3;url=login.html");
            ?>
        </body>
        </html>
        <?php
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
