<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 18.02.2019
 * Time: 22:28
 */

namespace Stallfish\CmsCommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Apoutchika\MediaBundle\Model\Media as BaseMedia;

/**
 * Media
 *
 * @ORM\Table(name="cms_media")
 * @ORM\Entity()
 */
class Media extends BaseMedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}