<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 01/06/2020
 * Time: 7:46 AM
 */

namespace App\Core\Auth;


use Rhomans\Lookout\Contracts\DataManager;

class AuthUserDetailsDataManager implements DataManager
{
    private $userDetails;


    /**
     * AuthUserDetailsDataManager constructor.
     * @param $userDetails
     */
    public function __construct($userDetails)
    {

        $this->userDetails = $userDetails;
    }

    public function identifier(): string
    {
        return $this->userDetails->user->username;
    }

    public function getData()
    {
        return json_encode($this->userDetails, JSON_UNESCAPED_SLASHES);
    }
}
