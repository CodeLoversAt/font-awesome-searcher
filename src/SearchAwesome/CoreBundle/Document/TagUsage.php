<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 03.07.14
 * @time 12:18
 */

namespace SearchAwesome\CoreBundle\Document;


class TagUsage
{
    /**
     * for serialization
     *
     * @var string
     */
    private $tagId;

    /**
     * for server side reference
     *
     * @var Tag
     */
    private $tag;

    /**
     * for search
     *
     * @var string
     */
    private $name;

    /**
     * for soundex search
     *
     * @var string
     */
    private $soundex;

    /**
     * whether or not this tag has been validated by an admi
     *
     * @var boolean
     */
    private $validated = false;

    /**
     * @var boolean
     */
    private $deleted = false;

    /**
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->setName($tag->getName())
            ->setSoundex($tag->getSoundex())
            ->setTagId($tag->getId())
            ->setTag($tag);
    }

    /**
     * @param string $name
     *
     * @return TagUsage
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $soundex
     *
     * @return TagUsage
     */
    public function setSoundex($soundex)
    {
        $this->soundex = $soundex;

        return $this;
    }

    /**
     * @return string
     */
    public function getSoundex()
    {
        return $this->soundex;
    }

    /**
     * @param \SearchAwesome\CoreBundle\Document\Tag $tag
     *
     * @return TagUsage
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return \SearchAwesome\CoreBundle\Document\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tagId
     *
     * @return TagUsage
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * @return boolean
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * @param boolean $validated
     *
     * @return Tag
     */
    public function setValidated($validated)
    {
        $this->validated = $validated == true;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     *
     * @return TagUsage
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted == true;

        return $this;
    }
}