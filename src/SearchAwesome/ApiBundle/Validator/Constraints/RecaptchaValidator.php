<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 15:53
 */

namespace SearchAwesome\ApiBundle\Validator\Constraints;


use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use SearchAwesome\ApiBundle\Form\Model\Recaptcha as RecaptchaModel;

class RecaptchaValidator extends ConstraintValidator
{
    const VERIFY_URL = 'http://www.google.com/recaptcha/api/verify';

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var string
     */
    private $sessionKey;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param string $privateKey
     * @param RequestStack $requestStack
     */
    public function __construct($privateKey, $sessionKey, RequestStack $requestStack)
    {
        $this->privateKey = $privateKey;
        $this->requestStack = $requestStack;
        $this->sessionKey = $sessionKey;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value           The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!($value instanceof RecaptchaModel)) {
            throw new \InvalidArgumentException('value must be instance of SearchAwesome\ApiBundle\Form\Model\Recaptcha');
        }

        $request = $this->requestStack->getCurrentRequest();

        if (false === $this->checkAnswer($request->getClientIp(), $this->privateKey, $value)) {
            $this->context->addViolation($constraint->message);
        } else {
            // once profen they're human, we don't need the captcha any longer
            $request->getSession()->set($this->sessionKey, true);
        }
    }

    private function checkAnswer($clientIp, $privateKey, RecaptchaModel $model)
    {
        // discard spam submissions
        if (!$model->getChallenge() || !$model->getResponse()) {
            return false;
        }

        $client = new Client();
        $response = $client->post(self::VERIFY_URL, array(
            'body' => array(
                'privatekey' => $privateKey,
                'remoteip'   => $clientIp,
                'challenge'  => $model->getChallenge(),
                'response'   => $model->getResponse(),
            )
        ));

        $parts = explode("\n", $response->getBody());

        return ('true' === trim($parts[0]));
    }
}