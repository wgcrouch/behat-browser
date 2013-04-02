<?php

namespace BehatBrowser\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 */
class Step
{
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
    protected $text;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $arguments;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Definition")
     */
    protected $definition;

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
     * Set text
     *
     * @param string $text
     * @return \Step
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text
     *
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set arguments
     *
     * @param string $arguments
     * @return \Step
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * Get arguments
     *
     * @return string $arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Set definition
     *
     * @param BehatBrowser\Bundle\CoreBundle\Document\Definition $definition
     * @return \Step
     */
    public function setDefinition(\BehatBrowser\Bundle\CoreBundle\Document\Definition $definition)
    {
        $this->definition = $definition;
        return $this;
    }

    /**
     * Get definition
     *
     * @return BehatBrowser\Bundle\CoreBundle\Document\Definition $definition
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}
