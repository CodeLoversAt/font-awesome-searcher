<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:11
 */

namespace SearchAwesome\CoreBundle\Manager;


use SearchAwesome\CoreBundle\Document\Tag;
use SearchAwesome\CoreBundle\Repository\TagRepository;
use Doctrine\Common\Persistence\ObjectManager;

class TagManager implements TagManagerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @var TagRepository
     */
    private $repo;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repo = $this->om->getRepository('SearchAwesomeCoreBundle:Tag');
    }


    /**
     * creates a new instance of Tag
     *
     * @return Tag
     */
    public function createTag()
    {
        return new Tag();
    }

    /**
     * finds the tag with the given id
     *
     * @param string $id
     *
     * @return Tag|null
     */
    public function findTag($id)
    {
        return $this->repo->find($id);
    }

    /**
     * returns all tags
     *
     * @return Tag[]
     */
    public function findTags(array $ids = array())
    {
        return $this->repo->findByIds($ids);
    }

    /**
     * finds all tags that match the given criteria
     *
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $skip
     *
     * @internal param array $citeria
     * @return Tag[]
     */
    public function findTagsBy(array $criteria, array $orderBy = array(), $limit = null, $skip = null)
    {
        return $this->repo->findBy($criteria, $orderBy, $limit, $skip);
    }

    /**
     * finds one Tag instance that matches the given criteria
     *
     * @param array $criteria
     *
     * @return Tag|null
     */
    public function findTagBy(array $criteria)
    {
        return $this->repo->findOneBy($criteria);
    }

    /**
     * persists the given Tag
     *
     * @param Tag $tag
     * @param boolean $andFlush
     */
    public function updateTag(Tag $tag, $andFlush = true)
    {
        $tag = $this->om->merge($tag);

        if (true === $andFlush) {
            $this->om->flush();
        }

        return $tag;
    }

    /**
     * deletes the given Tag
     *
     * @param Tag $tag
     * @param boolean $andFlush
     */
    public function removeTag(Tag $tag, $andFlush = true)
    {
        $this->om->remove($tag);

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

    /**
     * finds one Tag instance with the given name
     *
     * @param string $name
     *
     * @return Tag|null
     */
    public function findTagByName($name)
    {
        return $this->repo->findOneBy(array('name' => $name));
    }
}