<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:21
 */

namespace SearchAwesome\CoreBundle\Manager;


use SearchAwesome\CoreBundle\Document\Site;
use SearchAwesome\CoreBundle\Repository\SiteRepository;
use Doctrine\Common\Persistence\ObjectManager;

class SiteManager implements SiteManagerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var SiteRepository
     */
    private $repo;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repo = $this->om->getRepository('SearchAwesomeCoreBundle:Site');
    }

    /**
     * creates a new instance of Site
     *
     * @return Site
     */
    public function createSite()
    {
        return new Site();
    }

    /**
     * finds the Site with the given id
     *
     * @param string $id
     *
     * @return Site|null
     */
    public function findSite($id)
    {
        return $this->repo->find($id);
    }

    /**
     * returns all sites
     *
     * @param string[] $ids
     *
     * @return Site[]
     */
    public function findSites(array $ids = array())
    {
        return $this->repo->findByIds($ids);
    }

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
    public function findSitesBy(array $criteria, array $orderBy = array(), $limit = null, $skip = null)
    {
        return $this->repo->findBy($criteria, $orderBy, $limit, $skip);
    }

    /**
     * persists the given Tag
     *
     * @param Site $site
     * @param boolean $andFlush
     */
    public function updateSite(Site $site, $andFlush = true)
    {
        $this->om->persist($site);

        if (true === $andFlush) {
            $this->om->flush();
        }
    }

    /**
     * deletes the given Tag
     *
     * @param Site $site
     * @param boolean $andFlush
     */
    public function removeSite(Site $site, $andFlush = true)
    {
        $this->om->remove($site);

        if (true === $andFlush) {
            $this->om->flush();
        }
    }

    /**
     * persist all pending changes
     */
    public function flushChanges()
    {
        $this->om->flush();
    }
}