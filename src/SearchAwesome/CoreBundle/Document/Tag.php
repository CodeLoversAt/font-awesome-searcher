<?php

namespace SearchAwesome\CoreBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use SearchAwesome\ApiBundle\Form\Model\Recaptcha;
use Symfony\Component\Validator\Constraints as Assert;
use SearchAwesome\ApiBundle\Validator\Constraints\Recaptcha as Captcha;

/**
 * SearchAwesome\CoreBundle\Document\Tag
 * @JMS\ExclusionPolicy("all")
 * @MongoDBUnique(fields={"name"}, message="tag.alreadyExists", groups={"newTag"})
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
     * @JMS\Accessor(setter="setName")
     * @Assert\Type("string", groups={"newTag", "assignTag"})
     * @Assert\NotBlank(groups={"newTag", "assignTag"})
     */
    protected $name;

    /**
     * @var Recaptcha
     *
     * @Captcha(groups={"captcha"})
     */
    private $recaptcha;

    /**
     * whether or not this tag has been validated by an admi
     *
     * @var boolean
     *
     * @JMS\Type("boolean")
     * @JMS\Groups({"REST"})
     * @JMS\Expose()
     * @JMS\ReadOnly()
     * @JMS\SerializedName("isValidated")
     */
    private $validated = false;

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
        // make sure it is lower case
        $name = strtolower($name);

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

    /**
     * @return \SearchAwesome\ApiBundle\Form\Model\Recaptcha
     */
    public function getRecaptcha()
    {
        return $this->recaptcha;
    }

    /**
     * @param \SearchAwesome\ApiBundle\Form\Model\Recaptcha $recaptcha
     *
     * @return Tag
     */
    public function setRecaptcha(Recaptcha $recaptcha)
    {
        $this->recaptcha = $recaptcha;

        return $this;
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
}
