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
use SearchAwesome\CoreBundle\Document\Site;

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
     * @param string[] $ids
     *
     * @return Icon[]
     */
    public function findIcons(array $ids = array());

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
     * finds alll Icon instances that have tags
     * matching the given search term
     *
     * @param string $search
     *
     * @return Icon[]
     */
    public function findIconsByTagName($search);

    /**
     * persists the given Icon
     *
     * @param Icon $icon
     * @param boolean $andFlush
     *
     * @return Icon the managed entity
     */
    public function updateIcon(Icon $icon, $andFlush = true);

    /**
     * deletes the given Icon
     *
     * @param Icon $icon
     * @param boolean $andFlush
     */
    public function removeIcon(Icon $icon, $andFlush = true);

    /**
     * persist all pending changes
     */
    public function flushChanges();

    /**
     * finds an Icon instance with the given name
     * and the given Site
     *
     * @param string $name
     * @param Site $site
     *
     * @return Icon|null
     */
    public function findIconByName($name, $site);

    /**
     * finds an Icon instance matching the given criteria
     *
     * @param array $criteria
     *
     * @return Icon|null
     */
    public function findIconBy(array $criteria);
}