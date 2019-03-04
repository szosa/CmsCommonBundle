<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 17.02.2019
 * Time: 20:20
 */

namespace Stallfish\CmsCommonBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\GeneratorBundle\Annotation\Translation;

/**
 * Trait MetaTagsTrait
 * @package Stallfish\CmsCommonBundle\Entity\Traits
 */
trait MetaTagsTrait
{
    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="metaKeyword", type="string", length=255, nullable=true)
     */
    private $metaKeyword;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="metaTitle", type="string", length=255, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="metaDescription", type="text", nullable=true)
     */
    private $metaDescription;

    /**
     * Set metaKeyword
     *
     * @param string $metaKeyword
     *
     * @return self
     */
    public function setMetaKeyword(string $metaKeyword):self
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    /**
     * Get metaKeyword
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getMetaKeyword():?string
    {
        return $this->metaKeyword;
    }

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     *
     * @return self
     */
    public function setMetaTitle(string $metaTitle):self
    {
        $this->metaTitle = $metaTitle;

        return $this;
    }

    /**
     * Get metaTitle
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getMetaTitle():?string
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return self
     */
    public function setMetaDescription(string $metaDescription):self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getMetaDescription():?string
    {
        return $this->metaDescription;
    }
}