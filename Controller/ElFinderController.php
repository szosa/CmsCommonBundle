<?php

namespace Stallfish\CmsCommonBundle\Controller;

use FM\ElfinderBundle\Controller\ElFinderController as BaseController;
use Exception;
use FM\ElfinderBundle\Loader\ElFinderLoader;
use FM\ElfinderBundle\Session\ElFinderSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FM\ElfinderBundle\Event\ElFinderEvents;
use FM\ElfinderBundle\Event\ElFinderPreExecutionEvent;
use FM\ElfinderBundle\Event\ElFinderPostExecutionEvent;
use Symfony\Component\Routing\Annotation\Route;

class ElFinderController extends BaseController
{
    /**
     * Renders Elfinder.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     * @Route("/cms/file-manager", name="file_manager")
     */
    public function indexAction(Request $request)
    {
        $efParameters = $this->container->getParameter('fm_elfinder');

        if (empty($efParameters['instances']['default'])) {
            throw new NotFoundHttpException('Instance not found');
        }
        $parameters   = $efParameters['instances']['default'];

        if (empty($parameters['locale'])) {
            $parameters['locale'] = $request->getLocale();
        }

        $assetsPath   = $efParameters['assets_path'];
        $result       = $this->selectEditor($parameters, 'default', '', $assetsPath, $request->get('id'));


        return $this->render('@CmsCommon/FileManager/fileManager.html.twig', $result['params']);
    }

    /**
     * @param array  $parameters
     * @param string $instance
     * @param string $homeFolder
     * @param $assetsPath
     * @param null $formTypeId
     *
     * @return array
     *
     * @throws Exception
     */
    private function selectEditor($parameters, $instance, $homeFolder, $assetsPath, $formTypeId = null)
    {
        $editor         = $parameters['editor'];
        $locale         = $parameters['locale'] ?: $this->container->getParameter('locale');
        $fullScreen     = $parameters['fullscreen'];
        $relativePath   = $parameters['relative_path'];
        $pathPrefix     = $parameters['path_prefix'];
        $includeAssets  = $parameters['include_assets'];
        $theme          = $parameters['theme'];
        // convert to javascript array
        $onlyMimes      = count($parameters['visible_mime_types'])
            ? "['".implode("','", $parameters['visible_mime_types'])."']"
            : '[]';
        $result         = array();

        switch ($editor) {
            case 'custom':
                if (empty($parameters['editor_template'])) {
                    throw new Exception("Configuration error : 'custom' editor must define 'editor_template' parameter");
                }

                $result['template'] = $parameters['editor_template'];
                $result['params']   = array(
                    'locale'        => $locale,
                    'fullscreen'    => $fullScreen,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'relative_path' => $relativePath,
                    'prefix'        => $assetsPath,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                    'onlyMimes'     => $onlyMimes,
                );

                return $result;
            case 'ckeditor':
                $result['template'] = '@FMElfinder/Elfinder/ckeditor.html.twig';
                $result['params']   = array(
                    'locale'        => $locale,
                    'fullscreen'    => $fullScreen,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'relative_path' => $relativePath,
                    'prefix'        => $assetsPath,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                    'onlyMimes'     => $onlyMimes,
                );

                return $result;
            case 'summernote':
                $result['template'] = '@FMElfinder/Elfinder/summernote.html.twig';
                $result['params']   = array(
                    'locale'        => $locale,
                    'fullscreen'    => $fullScreen,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'relative_path' => $relativePath,
                    'prefix'        => $assetsPath,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                    'onlyMimes'     => $onlyMimes,
                );

                return $result;
            case 'tinymce':
                $result['template'] = '@FMElfinderBundle/Elfinder/tinymce.html.twig';
                $result['params']   = array(
                    'locale'             => $locale,
                    'tinymce_popup_path' => $this->getAssetsUrl($parameters['tinymce_popup_path']),
                    'includeAssets'      => $includeAssets,
                    'instance'           => $instance,
                    'homeFolder'         => $homeFolder,
                    'prefix'             => $assetsPath,
                    'theme'              => $theme,
                    'pathPrefix'         => $pathPrefix,
                    'onlyMimes'          => $onlyMimes,
                    'relative_path'      => $relativePath,
                    'fullscreen'         => $fullScreen
                );

                return $result;
            case 'tinymce4':
                $result['template'] = '@FMElfinder/Elfinder/tinymce4.html.twig';
                $result['params']   = array(
                    'locale'        => $locale,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'relative_path' => $relativePath,
                    'prefix'        => $assetsPath,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                    'onlyMimes'     => $onlyMimes,
                    'fullscreen'    => $fullScreen
                );

                return $result;
            case 'fm_tinymce':
                $result['template'] = '@FMElfinder/Elfinder/fm_tinymce.html.twig';
                $result['params']   = array(
                    'locale'        => $locale,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'relative_path' => $relativePath,
                    'prefix'        => $assetsPath,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                    'onlyMimes'     => $onlyMimes,
                );

                return $result;
            case 'form':
                $result['template'] = '@FMElfinder/Elfinder/elfinder_type.html.twig';
                $result['params']   = array(
                    'locale'        => $locale,
                    'fullscreen'    => $fullScreen,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'id'            => $formTypeId,
                    'relative_path' => $relativePath,
                    'prefix'        => $assetsPath,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                    'onlyMimes'     => $onlyMimes,
                );

                return $result;
            default:
                $result['template'] = '@FMElfinder/Elfinder/simple.html.twig';
                $result['params']   = array(
                    'locale'        => $locale,
                    'fullscreen'    => $fullScreen,
                    'includeAssets' => $includeAssets,
                    'instance'      => $instance,
                    'homeFolder'    => $homeFolder,
                    'prefix'        => $assetsPath,
                    'onlyMimes'     => $onlyMimes,
                    'theme'         => $theme,
                    'pathPrefix'    => $pathPrefix,
                );

                return $result;
        }
    }

}
