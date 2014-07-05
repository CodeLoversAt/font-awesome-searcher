<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 16:51
 */

namespace SearchAwesome\ApiBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

abstract class ApiType extends AbstractType
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface|\Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $session;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContextInterface
     */
    private $sc;

    /**
     * @var string
     */
    private $sessionKey;

    /**
     *
     * @return array
     */
    protected abstract function getBaseGroups();

    /**
     *
     * @return string
     */
    protected abstract function getDataClass();

    /**
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     * @param \Symfony\Component\Security\Core\SecurityContextInterface $sc
     */
    public function __construct($sessionKey, SessionInterface $session, SecurityContextInterface $sc)
    {
        $this->session = $session;
        $this->sc = $sc;
        $this->sessionKey = $sessionKey;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $groups = $this->getBaseGroups();

        if (true === $this->needsCaptcha()) {
            $groups[] = 'captcha';
        }

        $resolver->setDefaults(array(
            'data_class'         => $this->getDataClass(),
            'validation_groups'  => $groups,
            'csrf_protection'    => false,
            'cascade_validation' => true,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (true === $this->needsCaptcha()) {
            $builder->add('recaptcha', 'recaptcha');
        }
    }

    /**
     *
     * @return bool
     */
    protected function needsCaptcha()
    {
        return false === $this->sc->isGranted('IS_AUTHENTICATED_REMEMBERED') && !$this->session->get($this->sessionKey);
    }
}