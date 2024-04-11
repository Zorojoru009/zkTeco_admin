<?php 

require_once '../global-library/config.php';

class DBService {
    public static function saveUsersToDB($users) {
        global $conn; // Access the $conn variable from outside the class

        foreach ($users as $user) {
            // Extract user details
            $user_id = $user[0];
            $user_name = $user[1];
            $user_role = $user[2];

            // Check if user exists
            $userExists = $conn->prepare("SELECT * FROM tbl_users WHERE user_id = ?");
            $userExists->bindParam(1, $user_id);
            $userExists->execute();
            $check = $userExists->fetch();

            echo "<br/>";
            print_r($user);

            if (!$check) {
                // Insert user if not exists
                $insertUser = $conn->prepare("INSERT INTO tbl_users (user_id, name, role) VALUES (?, ?, ?)");
                $insertUser->bindParam(1, $user_id);
                $insertUser->bindParam(2, $user_name);
                $insertUser->bindParam(3, $user_role);
                $insertUser->execute();
                echo ("<br/>" . "savedSuccesfully");
            }
        }
    }
}

?>