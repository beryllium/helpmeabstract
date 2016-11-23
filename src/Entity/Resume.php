<?php
/**
 * Created by PhpStorm.
 * User: grahamdaniels
 * Date: 3/25/15
 * Time: 8:26 PM
 */

namespace Greydnls\Entity;

use Spot\Entity;

class Resume extends Entity
{
    protected static $mapper = 'Greydnls\Entity\Mapper\Resume';

    protected static $table = 'resumes';

    public static function fields()
    {
        return [
            'id'        => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'email'     => ['type' => 'string', 'required' => true, 'unique' => true],
            'fullname'  => ['type' => 'string', 'required' => true],
            'link'      => ['type' => 'string', 'required' => true],
            'posting'   => ['type' => 'string', 'required' => false],
            'max_chars' => ['type' => 'integer', 'required' => false]
        ];
    }

    public function getHtml()
    {
        $html = "<h3>Resume Submitted</h3>";
        $html .= "<b> Name: </b> " . $this->fullname . "<br>";
        $html .= "<b> Email: </b> " . $this->email . "<br>";
        $html .= "<b> Link: </b> <a href='" . $this->link . "' >Review Now</a><br><br><br>";
        $html .= "<b> Posting: </b> <a href='" . $this->posting . "' >Relevant Posting</a><br><br><br>";
        $html .= "<b> You're receiving this email because you signed up to volunteer to review resumes at HelpMeResume.com<br>";

        return $html;
    }
}
