<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 17.02.2019
 * Time: 20:24
 */

namespace Stallfish\CmsCommonBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\GeneratorBundle\Annotation\Translation;

/**
 * Trait OgTrait
 * @package Stallfish\CmsCommonBundle\Entity\Traits
 */
trait OgTrait
{
    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="ogTitle", type="string", length=255, nullable=true)
     */
    private $ogTitle;

    /**
     * @var string
     *
     * @Translation(trans=false)
     *
     * @ORM\Column(name="ogDescription", type="string", length=255, nullable=true)
     */
    private $ogDescription;

    /**
     * Set ogTitle
     *
     * @param string $ogTitle
     *
     * @return self
     */
    public function setOgTitle(string $ogTitle):self
    {
        $this->ogTitle = $ogTitle;

        return $this;
    }

    /**
     * Get ogTitle
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getOgTitle():?string
    {
        return $this->ogTitle;
    }

    /**
     * Set ogDescription
     *
     * @param string $ogDescription
     *
     * @return self
     */
    public function setOgDescription(string $ogDescription):self
    {
        $this->ogDescription = $ogDescription;

        return $this;
    }

    /**
     * Get ogDescription
     *
     * @Translation(trans=false, lang="empty")
     *
     * @return string
     */
    public function getOgDescription():?string
    {
        return $this->ogDescription;
    }
}