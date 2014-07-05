<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 19:11
 */

namespace SearchAwesome\CoreBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /**
     * @var \MongoId
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

}