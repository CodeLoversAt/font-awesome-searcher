<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 15:51
 */

namespace SearchAwesome\ApiBundle\Validator\Constraints;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Recaptcha extends Constraint
{
    public $message = 'recaptcha.invalid';

    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'recaptcha_validator';
    }
}