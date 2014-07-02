<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:26
 */

namespace SearchAwesome\CoreBundle\Manager;


use SearchAwesome\CoreBundle\Document\Icon;

interface IconManagerInterface
{
    /**
     * creates a new instance of Icon
     *
     * @return Icon
     */
    public function createIcon();

    /**
     * finds the icon with the given id
     *
     * @param string $id
     *
     * @return Icon|null
     */
    public function findIcon($id);

    /**
     * returns all icons
     *
     * @return Icon[]
     */
    public function findIcons();

    /**
     * finds all icons that match the given criteria
     *
     * @param array $criteria
     * @param array $orderBy
     *
     * @param int $limit
     * @param int $skip
     *
     * @internal param array $citeria
     * @return Icon[]
     */
    public function findIconsBy(array $criteria, array $orderBy = array(), $limit = null, $skip = null);

    /**
     * persists the given Icon
     *
     * @param Icon $icon
     * @param boolean $andFlush
     */
    public function updateIcon(Icon $icon, $andFlush = true);

    /**
     * deletes the given Icon
     *
     * @param Icon $icon
     * @param boolean $andFlush
     */
    public function removeIcon(Icon $icon, $andFlush = true);
} 