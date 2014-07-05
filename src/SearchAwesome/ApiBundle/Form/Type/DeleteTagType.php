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

class DeleteTagType extends ApiType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'delete_tag';
    }

    /**
     *
     * @return array
     */
    protected function getBaseGroups()
    {
        return array();
    }

    /**
     *
     * @return string
     */
    protected function getDataClass()
    {
        return 'SearchAwesome\ApiBundle\Form\Model\DeleteTag';
    }
}