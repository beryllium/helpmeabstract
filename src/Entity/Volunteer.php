<?php
/**
 * Created by PhpStorm.
 * User: grahamdaniels
 * Date: 3/25/15
 * Time: 8:26 PM
 */

namespace Greydnls\Entity;

use Spot\Entity;

class Volunteer extends Entity
{
    protected static $mapper = 'Greydnls\Entity\Mapper\Volunteer';
    protected static $table = 'volunteers';

    public static function fields()
    {
        return [
            'id'           => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'fullname'        => ['type' => 'string', 'required' => true],
            'twitter_username'         => ['type' => 'string'],
            'github_username'       => ['type' => 'string'],
            'email'    => ['type' => 'string', 'required' => true],
        ];
    }
}