<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 15:51
 */

namespace SearchAwesome\ApiBundle\Form\Model;

class Recaptcha
{
    /**
     * @var string
     */
    private $challenge;

    /**
     * @var string
     */
    private $response;

    /**
     * @param string $challenge
     *
     * @return Recaptcha
     */
    public function setChallenge($challenge)
    {
        $this->challenge = $challenge;

        return $this;
    }

    /**
     * @return string
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param string $response
     *
     * @return Recaptcha
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }
} 