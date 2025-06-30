<?php

namespace Src\Controllers;

use PDO;
use Src\Core\Controller;
use Src\Core\Utils\Request;
use Src\Models\User;
use PDOException;
use Src\Core\Utils\Annotations\Post;
use Src\Services\AuthService;

class Edit extends Controller
{
    #[Post('/updateProfile')]
    public function updateProfile(Request $request)
    {
        try {
            // Get user ID from session
            $user = AuthService::getAuthenticatedUser();

            if (!$user) {
                http_response_code(401);
                return json(['message' => 'Authentication required']);
            }

            $id = $user->id;

            // Extract and validate input
            $username = trim($request->body['username'] ?? '');
            $email = trim($request->body['email'] ?? '');

            if (empty($username) || empty($email)) {
                http_response_code(422);
                return json(['message' => 'Username and email are required']);
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(422);
                return json(['message' => 'Invalid email format']);
            }

            // Get current user from database
            $currentUser = User::findById($id);

            if (empty($currentUser)) {
                http_response_code(404);
                return json(['message' => 'User not found']);
            }



            $existingUser = User::find(['username' => $username]);
            if (!empty($existingUser) && $existingUser[0]->id != $id) {
                http_response_code(422);
                return json(['message' => 'Username already taken']);
            }

            $currentUser->username = $username;
            $currentUser->email = $email;

            try {
                $currentUser->update();
                AuthService::refreshPayload();
            } catch (PDOException $err) {
                http_response_code(508);
                return json(['message' => $err->getMessage()]);
            }

            $_SESSION['payload']['username'] = $username;
            $_SESSION['payload']['email'] = $email;

            http_response_code(200);
            return json([
                'message' => 'Profile updated successfully',
                'user' => [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email
                ]
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            return json(['message' => 'Database error occurred']);
        } catch (\Exception $e) {
            http_response_code(500);
            return json(['message' => 'An error occurred']);
        }
    }
    #[Post('/deleteUser')]
    public function deleteUser(Request $request)
    {
        header('Content-Type: application/json');
        try {
            $user = AuthService::getAuthenticatedUser();

            if (!$user) {
                http_response_code(401);
                return json(['message' => 'Authentication required']);
            }
            $id = $user->id;

            $userToDelete = User::findById($id);

            if ((!$userToDelete)) {
                http_response_code(404);
                return json(['message' => 'User not found']);
            }

            try {
                $userToDelete->delete();
                AuthService::destroySession();
            } catch (PDOException $err) {
                http_response_code(508);
                return json(['message' => $err->getMessage()]);
            }

            http_response_code(200);
            return json([
                'message' => 'user deleted successfully'
            ]);
        } catch (PDOException $e) {
            http_response_code(400);
            return json([
                'message' => $e->getMessage()
            ]);
        }
    }
}
