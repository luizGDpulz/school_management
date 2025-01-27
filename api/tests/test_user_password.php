<?php
// Include the necessary files
require_once ROOT_PATH . '/controllers/user_controller.php';

// Instantiate the UserController
$userController = new UserController();

// Define the user ID and the passwords
$user_id = 1; // ID of the existing user
$wrong_password = 'wrongPassword'; // Incorrect password
$new_password = 'newPassword'; // New password to set

// Verify the password with an incorrect one
$response = json_decode($userController->verifyUserPassword($user_id, $wrong_password), true);

// Check if the password is invalid
if ($response['message'] === "Invalid password.") {
    echo "Invalid password. Updating the password...\n";
    
    // Update the user's password
    $updateResponse = json_decode($userController->updateUserPassword($user_id, $new_password), true);
    
    // Output the result of the password update
    echo $updateResponse['message'] . "\n";
    
    // Verify the new password
    $verifyResponse = json_decode($userController->verifyUserPassword($user_id, $new_password), true);
    echo $verifyResponse['message'] . "\n"; // Should indicate that the password is valid now
} else {
    echo "Password is valid. No update needed.\n";
}
?>

