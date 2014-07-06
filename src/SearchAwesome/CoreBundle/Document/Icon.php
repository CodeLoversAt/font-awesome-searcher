<?php

namespace SearchAwesome\CoreBundle\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * SearchAwesome\CoreBundle\Document\Icon
 * @JMS\ExclusionPolicy("all")
 */
class Icon
{
    /**
     * @var \MongoId $id
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $id;

    /**
     * @var string $name
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     */
    protected $name;

    /**
     * @var array $versions
     *
     * @JMS\Type("array<string>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     */
    protected $versions;

    /**
     * @var array $aliases
     *
     * @JMS\Type("array<string>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     */
    protected $aliases = array();

    /**
     * @var string $cssClass
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\SerializedName("cssClass")
     */
    protected $cssClass;

    /**
     * @var \DateTime $created_at
     *
     * @JMS\Type("DateTime<'c'>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\SerializedName("createdAt")
     */
    protected $created_at;

    /**
     * @var \DateTime $updated_at
     *
     * @JMS\Type("DateTime<'c'>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\SerializedName("updatedAt")
     */
    protected $updated_at;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     */
    protected $unicode;

    /**
     * @var Collection
     *
     * @JMS\Type("array<string>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\Accessor(getter="getTagIds")
     * @JMS\ReadOnly()
     */
    protected $tags;

    /**
     * used for searching by keywords
     *
     * @var array
     *
     * @JMS\Type("array<string>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $keywords = array();

    /**
     * used for searching by soundex values
     *
     * @var array
     *
     * @JMS\Type("array<string>")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    protected $soundexes = array();

    /**
     * @var Site
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\Accessor(getter="getSiteId")
     * @JMS\ReadOnly()
     */
    protected $site;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set versions
     *
     * @param array $versions
     * @return self
     */
    public function setVersions(array $versions)
    {
        $this->versions = $versions;
        return $this;
    }

    /**
     * Get versions
     *
     * @return collection $versions
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * Set cssClass
     *
     * @param string $cssClass
     * @return self
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
        return $this;
    }

    /**
     * Get cssClass
     *
     * @return string $cssClass
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updated_at = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @return \SearchAwesome\CoreBundle\Document\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param \SearchAwesome\CoreBundle\Document\Site $site
     *
     * @return Icon
     */
    public function setSite(Site $site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     * @param bool $validated
     *
     * @return Icon
     */
    public function addTag(Tag $tag, $validated = false)
    {
        foreach ($this->tags as $tagUsage) {
            /** @var TagUsage $tagUsage */
            if ($tagUsage->getTagId() === $tag->getId()) {
                // ensure it is not deleted
                $tagUsage->setDeleted(false);
                return $this;
            }
        }
        $usage = new TagUsage($tag);
        $usage->setValidated($validated);
        $this->tags->add($usage);

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return Icon
     */
    public function removeTag(Tag $tag, $force = false)
    {
        foreach ($this->tags as $tagUsage) {
            /** @var TagUsage $tagUsage */
            if ($tagUsage->getTagId() === $tag->getId()) {
                if (true === $force) {
                    $this->tags->removeElement($tagUsage);
                } else {
                    $tagUsage->setDeleted(true);
                }
            }
        }

        return $this;
    }

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @return string
     */
    public function getUnicode()
    {
        return $this->unicode;
    }

    /**
     * @param string $unicode
     *
     * @return Icon
     */
    public function setUnicode($unicode)
    {
        $this->unicode = $unicode;

        return $this;
    }

    public function getTagIds()
    {
        $ids = array();

        foreach ($this->tags->filter(function(TagUsage $u) {
            return !$u->isDeleted();
        }) as $tagUsage) {
            /** @var TagUsage $tagUsage */
            $ids[] = $tagUsage->getTagId();
        }

        return $ids;
    }

    public function getSiteId()
    {
        return $this->getSite()->getId();
    }

    /**
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param string $alias
     *
     * @return Icon
     */
    public function addAlias($alias)
    {
        if (!in_array($alias, $this->aliases)) {
            $this->aliases[] = $alias;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getSoundexes()
    {
        return $this->soundexes;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
}
