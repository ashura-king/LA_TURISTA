<?php

namespace Src\Core\Utils\Annotations;

use Attribute;

#[Attribute()]
class Put extends Route
{
    public function __construct($path = "")
    {
        parent::__construct($path, 'PUT');
    }
}
