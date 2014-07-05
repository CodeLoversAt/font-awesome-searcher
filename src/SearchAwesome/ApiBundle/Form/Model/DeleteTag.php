<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 14:15
 */

namespace SearchAwesome\ApiBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use SearchAwesome\ApiBundle\Validator\Constraints\Recaptcha as Captcha;

class DeleteTag
{
    /**
     * @var Recaptcha
     *
     * @Captcha(groups={"captcha"})
     */
    private $recaptcha;

    /**
     * @param Recaptcha $recaptcha
     *
     * @return DeleteTag
     */
    public function setRecaptcha(Recaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;

        return $this;
    }

    /**
     * @return Recaptcha
     */
    public function getRecaptcha()
    {
        return $this->recaptcha;
    }
} 