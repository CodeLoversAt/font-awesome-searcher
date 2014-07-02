<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:27
 */

namespace SearchAwesome\CoreBundle\Manager;


use SearchAwesome\CoreBundle\Document\Icon;
use SearchAwesome\CoreBundle\Repository\IconRepository;
use Doctrine\Common\Persistence\ObjectManager;

class IconManager implements IconManagerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var IconRepository
     */
    private $repo;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repo = $this->om->getRepository('SearchAwesomeCoreBundle:Icon');
    }

    /**
     * creates a new instance of Icon
     *
     * @return Icon
     */
    public function createIcon()
    {
        return new Icon();
    }

    /**
     * finds the icon with the given id
     *
     * @param string $id
     *
     * @return Icon|null
     */
    public function findIcon($id)
    {
        return $this->repo->find($id);
    }

    /**
     * returns all icons
     *
     * @return Icon[]
     */
    public function findIcons()
    {
        return $this->repo->findAll();
    }

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
    public function findIconsBy(array $criteria, array $orderBy = array(), $limit = null, $skip = null)
    {
        return $this->repo->findBy($criteria, $orderBy, $limit, $skip);
    }

    /**
     * persists the given Icon
     *
     * @param Icon $icon
     * @param boolean $andFlush
     */
    public function updateIcon(Icon $icon, $andFlush = true)
    {
        $this->om->persist($icon);

        if (true === $andFlush) {
            $this->om->flush();
        }
    }

    /**
     * deletes the given Icon
     *
     * @param Icon $icon
     * @param boolean $andFlush
     */
    public function removeIcon(Icon $icon, $andFlush = true)
    {
        $this->om->remove($icon);

        if (true === $andFlush) {
            $this->om->flush();
        }
    }
}