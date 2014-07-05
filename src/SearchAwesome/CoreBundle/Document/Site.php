<?php

namespace SearchAwesome\CoreBundle\Document;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * SearchAwesome\CoreBundle\Document\Site
 * @JMS\ExclusionPolicy("all")
 */
class Site
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
     * @var string $url
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     */
    protected $url;

    /**
     * @var string $url
     *
     * @JMS\Type("string")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\SerializedName("detailsPath")
     */
    protected $detailsPath;

    /**
     * @var Collection
     */
    protected $icons;

    /**
     * constructor
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
     * Set url
     *
     * @param string $url
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
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
     * @return Site
     */
    public function addIcon(Icon $icon)
    {
        $this->icons->add($icon);
        $icon->setSite($this);

        return $this;
    }

    /**
     * @param Icon $icon
     *
     * @return Site
     */
    public function removeIcon(Icon $icon)
    {
        $this->icons->removeElement($icon);

        return $this;
    }

    /**
     * @return string
     */
    public function getDetailsPath()
    {
        return $this->detailsPath;
    }

    /**
     * @param string $detailsPath
     *
     * @return Site
     */
    public function setDetailsPath($detailsPath)
    {
        $this->detailsPath = $detailsPath;

        return $this;
    }
}
