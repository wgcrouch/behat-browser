<?php

namespace BehatBrowser\Bundle\CoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Accessor;

/**
 * @MongoDB\Document(collection="features")
 */
class Feature
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $description;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $tags = array();

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @MongoDB\EmbedMany(targetDocument="Scenario")
     */
    protected $scenarios;

    /**
     * @MongoDB\EmbedMany(targetDocument="Step")
     */
    protected $backgroundSteps;


    public function __construct()
    {
        $this->scenarios = new ArrayCollection();
        $this->backGroundSteps = new ArrayCollection();
    }

    /**
     * Set description
     *
     * @param string $description
     * @return \Definition
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return \Feature
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
     * Add scenarios
     *
     * @param BehatBrowser\Bundle\CoreBundle\Document\Scenario $scenarios
     */
    public function addScenario(\BehatBrowser\Bundle\CoreBundle\Document\Scenario $scenarios)
    {
        $this->scenarios[] = $scenarios;
    }

    /**
    * Remove scenarios
    *
    * @param <variableType$scenarios
    */
    public function removeScenario(\BehatBrowser\Bundle\CoreBundle\Document\Scenario $scenarios)
    {
        $this->scenarios->removeElement($scenarios);
    }

    /**
     * Get scenarios
     *
     * @return Doctrine\Common\Collections\Collection $scenarios
     */
    public function getScenarios()
    {
        return $this->scenarios;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return \Feature
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
     * Add backgroundSteps
     *
     * @param BehatBrowser\Bundle\CoreBundle\Document\Step $backgroundSteps
     */
    public function addBackgroundStep(\BehatBrowser\Bundle\CoreBundle\Document\Step $backgroundSteps)
    {
        $this->backgroundSteps[] = $backgroundSteps;
    }

    /**
    * Remove backgroundSteps
    *
    * @param <variableType$backgroundSteps
    */
    public function removeBackgroundStep(\BehatBrowser\Bundle\CoreBundle\Document\Step $backgroundSteps)
    {
        $this->backgroundSteps->removeElement($backgroundSteps);
    }

    /**
     * Get backgroundSteps
     *
     * @return Doctrine\Common\Collections\Collection $backgroundSteps
     */
    public function getBackgroundSteps()
    {
        return $this->backgroundSteps;
    }

    public function clearBackGroundSteps() {
        $this->backgroundSteps = new ArrayCollection();
    }

    public function clearScenarios() {
        $this->scenarios = new ArrayCollection();
    }

    public function getScenario($id)
    {
        foreach ($this->scenarios as $scenario) {
            if ($id == $scenario->getId()) {
                return $scenario;
            }
        }
        return null;
    }
}
