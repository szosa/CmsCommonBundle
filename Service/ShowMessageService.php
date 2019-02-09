<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 09.02.2019
 * Time: 23:03
 */

namespace Stallfish\CmsCommonBundle\Service;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class ShowMessageService
{
    /**
     * @var \Twig_Environment
     */
    private $template;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * ShowMessageService constructor.
     * @param \Twig_Environment $template
     * @param TranslatorInterface $translator
     */
    public function __construct(\Twig_Environment $template, TranslatorInterface $translator)
    {
        $this->template = $template;
        $this->translator = $translator;
    }

    /**
     * @param string $header
     * @param string $message
     * @param string $type
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderMessage(string $header, string $message, string $type)
    {
        return new Response($this->template->render('@CmsUserBundle/security/messageView.html.twig',[
            'header' => $this->translator->trans($header),
            'message'=> $this->translator->trans($message),
            'type' => $type
        ]));
    }
}