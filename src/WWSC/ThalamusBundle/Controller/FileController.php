<?php

namespace WWSC\ThalamusBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WWSC\ThalamusBundle\Entity\Files;
use Symfony\Component\HttpFoundation\JsonResponse;
use WWSC\ThalamusBundle\Entity\Project;
use WWSC\ThalamusBundle\Service\MailService;
use ZipArchive;

/**
 * File controler.
 *
 * In this controller describes the functions of registration new account and display pages dashboard, To-Dos, Calendar, Settings, Templates for account.
 */
class FileController extends Controller
{
    /**
     *  Method add.
     *
     *  This method is responsible for show page multiupload files.
     */
    public function addAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            $aCategoryFile = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oProject->getId(),
                'type' => 'FILE',
            ));

            if ('POST' == $request->getMethod()) {
                if ($request->get('aFiles') && $request->get('aSubspeople')) {
                    $this->sendFileToEmail($request->get('aFiles'), $request->get('aSubspeople'), $request->get('project'));
                }

                return $this->redirect($this->generateUrl('wwsc_thalamus_project_file_list', array('project' => $request->get('project'))));
            }

            return $this->render('WWSCThalamusBundle:File:add.html.twig', array('oProject' => $oProject, 'aCategoryFile' => $aCategoryFile));
        }
    }

    /**
     *  Method edit.
     *
     *  This method is responsible for edit more information about file.
     */
    public function editAction(Request $request)
    {
        $oFile = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Files')->find($request->get('id'));
        if ($oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            $aCategoryFile = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oProject->getId(),
                'type' => 'FILE',
            ));
            $fFile = $this->createForm(new \WWSC\ThalamusBundle\Form\FilesForm($aCategoryFile), $oFile);
            $formView = $fFile->createView();
            $formView->children['category']->vars['choices'][] = new \Symfony\Component\Form\Extension\Core\View\ChoiceView(null, 'add!', '— add a new category —');
            if ('POST' == $request->getMethod()) {
                $fFile->bind($request);
                if ($fFile->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $fFile = $fFile->getData();
                    $em->persist($fFile);
                    $em->flush();

                    return new JsonResponse(array('htmlFile' => $this->renderView('WWSCThalamusBundle:File:show.html.twig', array('oFile' => $fFile))));
                }
                $errors = $fFile->getErrors();
                $output = array();
                $output['error'] = $errors[0]->getMessage();

                return new \Symfony\Component\HttpFoundation\JsonResponse($output);
            }

            return new JsonResponse(array('htmlFormFile' => $this->renderView('WWSCThalamusBundle:File:edit.html.twig', array('oFile' => $oFile, 'aCategoryFile' => $aCategoryFile, 'form' => $formView))));
        }
    }

    /**
     *  Method list.
     *
     *  This method is responsible for display list files  on  the page "Files"
     */
    public function listAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'files');
        if ($oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')))) {
            if (0 == count($oProject->getFiles())) {
                return $this->render('WWSCThalamusBundle:File:empty-files.html.twig', array('oProject' => $oProject));
            }
            $aCategory = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Category')->findBy(array(
                'is_deleted' => 0,
                'project' => $oProject->getId(),
                'type' => 'FILE',
            ));

            $aUsersUpload = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Files')
                ->createQueryBuilder('a')
                ->where('a.project ='.$oProject->getId())
                ->groupBy('a.user_created')
                ->getQuery()
                ->getResult();
            $request->getSession()->set('aFilterFiles', array('cat' => $request->get('cat'), 'user_uploaded' => $request->get('user_uploaded')));

            $page = $request->get('page', 1);

            $aFilesCrit = $oProject->getFiles($request->get('order', 'created'), $request->get('cat'), $request->get('user_uploaded'), true, $page);

            if ($request->isXmlHttpRequest()) {
                $filesRender = '';
                $fileSizes = 0;

                foreach ($aFilesCrit['aFiles'] as $aFile) {
                    $fileSizes += $aFile->getFileSize();

                    $filesRender .= $this->render('WWSCThalamusBundle:File:show.html.twig', array('oFile' => $aFile))->getContent();
                }

                $fileSizes = round($fileSizes / 1048576, 2);

                return new Response($filesRender, 200, array('fileSizes' => $fileSizes));
            }
            else {
                $response = $this->render('WWSCThalamusBundle:File:list.html.twig', array(
                    'oProject' => $oProject,
                    'currentPage' => $page,
                    'aCategory' => $aCategory,
                    'aUsersUpload' => $aUsersUpload,
                    'totalFilesSize' => 230,
                    'aFiles' => $aFilesCrit['aFiles'],
                    'totalFileSize' => $aFilesCrit['totalFileSize'],
                ));
            }

            return $response;
        }
    }

    public function createArchiveAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $request->getSession()->set('active_module', 'files');
        $aFilterFiles = $request->getSession()->get('aFilterFiles');
        $oProject = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $request->get('project')));
        if ($oProject instanceof Project) {
            $aFiles = $oProject->getFiles($request->get('order', 'created'), $aFilterFiles['cat'], $aFilterFiles['user_uploaded'], 'all');
            $archive_file_name = date('Ymd').'_'.$request->get('project').'.zip';
            ini_set('max_execution_time', 300);
            $zip = new ZipArchive();
            if (true === $zip->open($archive_file_name, ZIPARCHIVE::CREATE)) {
                try {
                    foreach ($aFiles['aFiles'] as $oFile) {
                        $file_src = $this->getParameter('web_dir').$oFile->getFileSrc();
                        if (file_exists($file_src)) {
                            $zip->addFile($file_src, $oFile->getName());
                        }
                    }
                    unset($aFiles);
                    if ($zip->numFiles < 1) {
                        return $this->redirect($request->headers->get('referer'));
                    }
                    $zip->close();
                } catch (\Exception $e) {

                    $zip->close();
                    unlink($archive_file_name);

                    return new JsonResponse(array('error' => true));
                }
            }
        }
        $urlDownloadZip = $request->getScheme().'://'.$request->getHttpHost().'/project/'.$request->get('project').'/file/'.$archive_file_name.'/download';

        return new JsonResponse(array('urlDownloadZip' => $urlDownloadZip));
    }

    public function downloadArchiveAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        if ($request->get('name')) {
            try {
                $archive_file_name = $request->get('name');
                header('Pragma: public');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Cache-Control: public');
                header('Content-Description: File Transfer');
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$archive_file_name.'"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: '.filesize($archive_file_name));
                ob_end_flush();
                @readfile($archive_file_name);
                unlink($archive_file_name);

                return true;
            } catch (\Exception $e) {
                unlink($archive_file_name);

                return $this->redirect($this->generateUrl('wwsc_thalamus_account_dashboard'));
            }
        }
    }

    /**
     *  Method show image with annotations.
     */
    public function showImageWithAnnotationsAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oFile = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Files')->find($request->get('id'));

        return $this->render('WWSCThalamusBundle:File:show-image-with-annotations.html.twig', array('oFile' => $oFile));
    }

    /**
     *  Method view all Images.
     *
     *  This method is responsible for display all images for comments or messages
     */
    public function viewAllImagesAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }
        $oElement = $this->getDoctrine()->getRepository('WWSCThalamusBundle:'.$request->get('type'))->find($request->get('id'));

        return $this->render('WWSCThalamusBundle:File:view-all-images.html.twig', array('aImages' => $oElement->getFiles('IMG')));
    }

    /**
     *  Method delete.
     *
     *  This method is responsible for delete file
     */
    public function deleteAction(Request $request)
    {
        if (!$this->getUser()->getHasRoleProject($request->get('project'))) {
            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $oFile = $this->getDoctrine()->getRepository('WWSCThalamusBundle:Files')->find($request->get('id'));
        $fileSrc = __DIR__.'/../../../../web'.$oFile->getFileSrc();
        if (file_exists($fileSrc)) {
            unlink($fileSrc);
        }
        $em->remove($oFile);
        $em->flush();

        return new Response(1);
    }

    /**
     *  Method send files to email.
     *
     *  The method responsible for  sending  files  to users email
     */
    public function sendFileToEmail($aFiles, $aUsers, $projectSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $oProject = $em->getRepository('WWSCThalamusBundle:Project')->findOneBy(array('slug' => $projectSlug));
        $critFiles = $em->getRepository('WWSCThalamusBundle:Files')->findBy(array('id' => $aFiles));
        $critUsers = $em->getRepository('WWSCThalamusBundle:User')->findBy(array('id' => $aUsers));
        $aUsers = array();
        foreach ($critUsers as $oUser) {
            $aUsers['name'][$oUser->getId()] = $oUser->getFirstName().' '.$oUser->getLastName();
            $aUsers['email'][$oUser->getId()] = $oUser->getEmail();
            $aUsers['lang'][$oUser->getId()] = $oUser->getLanguageCode();
        }

        /**
         * @var MailService $mailService
         */
        $mailService = $this->get('app.mail.service');

        foreach ($aUsers['email'] as $userEmailKey => $userEmail) {
            
            $mailBody = $this->renderView('WWSCThalamusBundle:Mail:'.$aUsers['lang'][$userEmailKey].'/subscribe_files.txt.twig', array(
                'aElements' => $critFiles,
                'oProject' => $oProject,
                'aUsers' => $aUsers['name'],
            ));
            
            $mailService->send(
                '['.$oProject->getName().'] New files have been uploaded', 
                $this->container->getParameter('admin_email'), 
                $userEmail, 
                $mailBody
            );
            
        }
    }

    public function getFileAction(Request $request)
    {
        $oFile = $this->getDoctrine()->getManager()->getRepository('WWSCThalamusBundle:Files')->findOneBy(array('file_src' => '/uploads/files/'.$request->get('name')));
        if ($oFile instanceof Files) {
            if ($this->getUser()->getHasRoleProject($oFile->getProject()->getSlug())) {
                if ('Comment' == $oFile->getType() && $oFile->getParentInfo()) {
                    if ('TaskItem' == $oFile->getParentInfo()->getType()) {
                        if (!(($this->container->get('security.context')->isGranted('ROLE_PROVIDER')) ||
                            ($oFile->getParentInfo()->getParentInfo()->getTask()->getVisibleClient() && $this->container->get('security.context')->isGranted('ROLE_CLIENT')) ||
                            ($oFile->getParentInfo()->getParentInfo()->getTask()->getVisibleFreelancer() && $this->container->get('security.context')->isGranted('ROLE_FREELANCER')))) {
                            return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
                        }
                    }
                }
                $file_src = __DIR__.'/../../../../web/uploads/files/'.$request->get('name');
                $newFileName = __DIR__.'/../../../../web/uploads/files/'.$oFile->getName();
                rename($file_src, $newFileName);
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                header('Content-Disposition: attachment; filename='.$oFile->getName());
                header('Content-Type: '.finfo_file($finfo, $newFileName));
                readfile($newFileName);
                rename($newFileName, $file_src);
                die();
            } else {
                return $this->render('WWSCThalamusBundle:Content:not_permission.html.twig');
            }
        }

        return true;
    }
}
