<?php

namespace Src\Controllers;

use PDOException;
use Src\Core\App;
use Src\Core\Controller;
use Src\Core\Utils\Annotations\Get;
use Src\Core\Utils\Annotations\Post;
use Src\Core\Utils\Request;
use Src\Core\Utils\Token;
use Src\Models\Rating;

class Rate extends Controller
{

  #[Post('/ratings')]
  public function addRatingHandler(Request $request)
  {
    $token = $_COOKIE['auth_token'] ?? "";
    $payload = Token::verify($token, $_ENV['SECRET_KEY']);

    if (!$payload) {
      http_response_code(403);
      return redirect('/front');
    }

    $name = $payload->username;

    $rating = isset($request->form_data['rating']) ? (int)$request->form_data['rating'] : 0;
    $message = $request->form_data['message'] ?? '';

    $errors = [];

    // Validate the rating
    if ($rating < 1 || $rating > 5) {
      $errors['rating'] = 'Rating must be between 1 and 5.';
    }


    // Create a new review object
    $newRating = new Rating(null, $name, $rating, $message);

    try {
      // Add the new review to the database
      $newRating->addReview();
      // Redirect back to the destinations page with success message
      http_response_code(200);

      return json([
        'message' => 'New review added.',
        'rating' => $newRating,
        'name' => $newRating->name,

      ]);
    } catch (PDOException $e) {

      return json([
        'message' => 'Failed to add review',
        'error' => $e->getMessage()
      ]);
    }
  }


  #[Get('/ratings')]
  public function showRatings(Request $request)
  {
    // Fetch all reviews from the database
    $reviews = Rating::getReviews();

    // Fetch the average rating
    $averageRating = Rating::getAverageRating();

    return view('ratings.view', [
      'averageRating' => round($averageRating, 2),
      'reviews' => $reviews,
    ]);
  }
}
