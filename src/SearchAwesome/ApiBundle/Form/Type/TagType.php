<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 05.07.14
 * @time 14:07
 */

namespace SearchAwesome\ApiBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class TagType extends ApiType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'sa_tag';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('name', 'text');
    }

    /**
     *
     * @return array
     */
    protected function getBaseGroups()
    {
        return array(
            'assignTag',
        );
    }

    protected function getDataClass()
    {
        return 'SearchAwesome\CoreBundle\Document\Tag';
    }
}