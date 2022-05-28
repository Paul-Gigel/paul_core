<?php

namespace paul_core\paul_core;

use paul_core\paul_core\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}