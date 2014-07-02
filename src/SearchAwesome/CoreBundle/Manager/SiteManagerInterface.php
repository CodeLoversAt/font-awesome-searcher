<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:19
 */

namespace SearchAwesome\CoreBundle\Manager;


use SearchAwesome\CoreBundle\Document\Site;

interface SiteManagerInterface
{
    /**
     * creates a new instance of Site
     *
     * @return Site
     */
    public function createSite();

    /**
     * finds the Site with the given id
     *
     * @param string $id
     *
     * @return Site|null
     */
    public function findSite($id);

    /**
     * returns all sites
     *
     * @return Site[]
     */
    public function findSites();

    /**
     * finds all tags that match the given criteria
     *
     * @param array $criteria
     * @param array $orderBy
     *
     * @param int $limit
     * @param int $skip
     *
     * @internal param array $citeria
     * @return Site[]
     */
    public function findSitesBy(array $criteria, array $orderBy = array(), $limit = null, $skip = null);

    /**
     * persists the given Tag
     *
     * @param Site $site
     * @param boolean $andFlush
     */
    public function updateSite(Site $site, $andFlush = true);

    /**
     * deletes the given Tag
     *
     * @param Site $site
     * @param boolean $andFlush
     */
    public function removeSite(Site $site, $andFlush = true);
}