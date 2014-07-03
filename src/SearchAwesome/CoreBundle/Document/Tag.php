<?php

namespace SearchAwesome\CoreBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * SearchAwesome\CoreBundle\Document\Tag
 * @JMS\ExclusionPolicy("all")
 */
class Tag
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
     * @var Collection
     *
     * @JMS\Type("ArrayCollection<SearchAwesome\CoreBundle\Document\Icon>")
     */
    protected $icons;

    /**
     * soundex value for searching
     *
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\ReadOnly()
     */
    private $soundex;

    /**
     *
     */
    public function __construct()
    {
        $this->icons = new ArrayCollection();
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
        if ($name !== $this->name) {
            $this->soundex = soundex($name);
        }

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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * @param Icon $icon
     *
     * @return Tag
     */
    public function addIcon(Icon $icon)
    {
        $this->icons->add($icon);
        $icon->getTags()->add($this);

        return $this;
    }

    /**
     * @param Icon $icon
     *
     * @return Tag
     */
    public function removeIcon(Icon $icon)
    {
        $this->icons->removeElement($icon);
        $icon->getTags()->removeElement($this);

        return $this;
    }

    /**
     * @return string
     */
    public function getSoundex()
    {
        return $this->soundex;
    }

    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
