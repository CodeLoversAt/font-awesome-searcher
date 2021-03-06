<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 15:08
 */

namespace SearchAwesome\CoreBundle\Manager;


use SearchAwesome\CoreBundle\Document\Tag;

interface TagManagerInterface
{
    /**
     * creates a new instance of Tag
     *
     * @return Tag
     */
    public function createTag();

    /**
     * finds the tag with the given id
     *
     * @param string $id
     *
     * @return Tag|null
     */
    public function findTag($id);

    /**
     * returns all tags
     *
     * @param array $ids optional - ids to filter
     *
     * @return Tag[]
     */
    public function findTags(array $ids = array());

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
     * @return Tag[]
     */
    public function findTagsBy(array $criteria, array $orderBy = array(), $limit = null, $skip = null);

    /**
     * finds one Tag instance that matches the given criteria
     *
     * @param array $criteria
     *
     * @return Tag|null
     */
    public function findTagBy(array $criteria);

    /**
     * persists the given Tag
     *
     * @param Tag $tag
     * @param boolean $andFlush
     */
    public function updateTag(Tag $tag, $andFlush = true);

    /**
     * deletes the given Tag
     *
     * @param Tag $tag
     * @param boolean $andFlush
     */
    public function removeTag(Tag $tag, $andFlush = true);

    /**
     * persist all pending changes
     */
    public function flushChanges();

    /**
     * finds one Tag instance with the given name
     *
     * @param string $name
     *
     * @return Tag|null
     */
    public function findTagByName($name);
}