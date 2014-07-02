<?php

namespace SearchAwesome\CoreBundle\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * Backend\CoreBundle\Document\Icon
 */
class Icon
{
    /**
     * @var \MongoId $id
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     */
    protected $id;

    /**
     * @var string $name
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     */
    protected $name;

    /**
     * @var array $versions
     *
     * @JMS\Type("array<string>")
     * @JMS\Groups({"REST"})
     */
    protected $versions;

    /**
     * @var string $cssClass
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     */
    protected $cssClass;

    /**
     * @var \DateTime $created_at
     *
     * @JMS\Type("DateTime<'u'>")
     * @JMS\Groups({"REST"})
     */
    protected $created_at;

    /**
     * @var \DateTime $updated_at
     *
     * @JMS\Type("DateTime<'u'>")
     * @JMS\Groups({"REST"})
     */
    protected $updated_at;

    /**
     * @var Collection
     */
    protected $tags;

    /**
     * @var Site
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
     * @return \Backend\CoreBundle\Document\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param \Backend\CoreBundle\Document\Site $site
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
     *
     * @return Icon
     */
    public function addTag(Tag $tag)
    {
        $this->tags->add($tag);
        $tag->getIcons()->add($this);

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return Icon
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
        $tag->getIcons()->removeElement($this);

        return $this;
    }

    public function prePersist()
    {
        $this->created_at = new \DateTime();
    }

    public function preUpdate()
    {
        $this->updated_at = new \DateTime();
    }
}
