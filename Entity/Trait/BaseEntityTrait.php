<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 17.01.2019
 * Time: 15:22
 */

namespace Stallfish\CmsCommonBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\GeneratorBundle\Annotation\Translation;

trait BaseEntityTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Translation(trans=false, lang="empty")
     */
    private $id;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="creationDate", type="datetime", nullable=true)
     *
     * @Translation(trans=false, lang="empty")
     */
    private $creationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="editDate", type="datetime", nullable=true)
     *
     * @Translation(trans=false, lang="empty")
     */
    private $editDate;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=true, options={"default":true})
     *
     * @Translation(trans=false, lang="empty")
     */
    private $isActive;

    /**
     * Get id.
     *
     * @return int
     *
     * @Translation(trans=false, lang="empty")
     */
    public function getId():?int
    {
        return $this->id;
    }


    /**
     * Set editDate.
     *
     * @param \DateTime|null $editDate
     *
     * @return object
     */
    public function setEditDate(\DateTime $editDate = null)
    {
        $this->editDate = $editDate;

        return $this;
    }

    /**
     * Get editDate.
     *
     * @return \DateTime|null
     *
     * @Translation(trans=false, lang="empty")
     */
    public function getEditDate()
    {
        return $this->editDate;
    }

    /**
     * Set isActive.
     *
     * @param bool|null $isActive
     *
     * @return object
     */
    public function setIsActive(bool $isActive = null)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool|null
     *
     * @Translation(trans=false, lang="empty")
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime|null $creationDate
     *
     * @return object
     */
    public function setCreationDate($creationDate = null)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime|null
     *
     * @Translation(trans=false, lang="empty")
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}
