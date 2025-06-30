<?php

namespace Src\Core\Utils\Annotations;

use Attribute;

#[Attribute()]
class Delete extends Route
{
    public function __construct($path = "")
    {
        parent::__construct($path, 'DELETE');
    }
}
