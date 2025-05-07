<?php

namespace Src\Models;

use Src\Core\Model;

class Rating extends Model
{
  public $reviewID;
  public $name;
  public $rating;
  public $message;
  public $createdAt;

  public function __construct(
    $reviewID = null,
    $name = null,
    $rating = null,
    $message = null,
    $createdAt = null
  ) {
    $this->reviewID = $reviewID;
    $this->name = $name;
    $this->rating = $rating;
    $this->message = $message;
    $this->createdAt = $createdAt;
  }

  public static function initRating()
  {
    self::migrateModel('
            reviewID INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
            message TEXT,
            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ');
  }


  public function addReview()
  {
    return $this->save();
  }

  public static function getReviews()
  {
    return self::find([]);
  }


  public static function getAverageRating()
  {
    $result = self::query('SELECT AVG(rating) as avg_rating FROM ratings');
    return isset($result[0]->avg_rating) ? $result[0]->avg_rating : 0;
  }
}