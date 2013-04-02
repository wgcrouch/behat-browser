<?php

namespace BehatBrowser\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @MongoDB\EmbeddedDocument
 */
class Scenario
{
    const TYPE_SCENARIO = 'scenario';
    const TYPE_OUTLINE = 'outline';

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="string")
     */
    protected $type;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="string")
     */
    protected $title;

    /**
     * @Assert\NotBlank()
     * @MongoDB\Field(type="collection")
     */
    protected $tags = array();

    /**
     * @MongoDB\EmbedMany(targetDocument="Step")
     */
    protected $steps;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return custom_id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return \Scenario
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Scenario
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return \Scenario
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get tags
     *
     * @return string $tags
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add steps
     *
     * @param BehatBrowser\Bundle\CoreBundle\Document\Step $steps
     */
    public function addStep(\BehatBrowser\Bundle\CoreBundle\Document\Step $steps)
    {
        $this->steps[] = $steps;
    }

    /**
    * Remove steps
    *
    * @param <variableType$steps
    */
    public function removeStep(\BehatBrowser\Bundle\CoreBundle\Document\Step $steps)
    {
        $this->steps->removeElement($steps);
    }

    /**
     * Get steps
     *
     * @return Doctrine\Common\Collections\Collection $steps
     */
    public function getSteps()
    {
        return $this->steps;
    }

    public function clearSteps()
    {
        $this->steps = new ArrayCollection();
    }
}
