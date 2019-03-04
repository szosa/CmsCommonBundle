<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 17.02.2019
 * Time: 20:32
 */

namespace Stallfish\CmsCommonBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\GeneratorBundle\Annotation\Translation;

/**
 * Trait BasePageTrait
 * @package Stallfish\CmsCommonBundle\Entity\Traits
 */
trait BasePageTrait
{
    /**
     * @var \DateTime
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="publishStart", type="datetime", nullable=true)
     */
    private $publishStart;

    /**
     * @var \DateTime
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="publishEnd", type="datetime", nullable=true)
     */
    private $publishEnd;


    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="template", type="string", length=255, nullable=true)
     */
    private $template;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * Set publishStart
     *
     * @param \DateTime $publishStart
     *
     * @return self
     */
    public function setPublishStart(\DateTime $publishStart):self
    {
        $this->publishStart = $publishStart;

        return $this;
    }

    /**
     * Get publishStart
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return \DateTime
     */
    public function getPublishStart():?\DateTime
    {
        return $this->publishStart;
    }

    /**
     * Set publishEnd
     *
     * @param \DateTime $publishEnd
     *
     * @return self
     */
    public function setPublishEnd(\DateTime $publishEnd):self
    {
        $this->publishEnd = $publishEnd;

        return $this;
    }

    /**
     * Get publishEnd
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return \DateTime
     */
    public function getPublishEnd():?\DateTime
    {
        return $this->publishEnd;
    }

    /**
     * Set template
     *
     * @param string $template
     *
     * @return self
     */
    public function setTemplate($template):self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getTemplate():?string
    {
        return $this->template;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return self
     */
    public function setSlug(string $slug):self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getSlug():?string
    {
        return $this->slug;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status):self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getStatus():?string
    {
        return $this->status;
    }



}