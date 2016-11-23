<?php
/**
 * Created by PhpStorm.
 * User: grahamdaniels
 * Date: 3/25/15
 * Time: 8:29 PM
 */

namespace Greydnls\Entity\Mapper;

use Spot\Mapper;


class Resume extends Mapper
{
    public function verifyFields()
    {
        //@todo update this error message to be more detailed
        if (empty($_POST['name']) && empty($_POST['email']) || empty($_POST['link'])) {
            return array('error' => 'All Fields Are Required.');
        }

        //@todo update this to google docs
        //@todo (later) update this to be much more flexible
        if (strpos($_POST['link'], 'gist.github.com') == false) {
            return array('error' => 'Unfortunately we can only accept Gist links at this');
        }

        return array();
    }
}
