<?php

namespace WWSC\ThalamusBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use WWSC\ThalamusBundle\Entity\Files;

class UploadListener {
    public function __construct($doctrine) {
        $this->doctrine = $doctrine;
    }

    public function onUpload(PostPersistEvent $event) {
        if ('POST' == $event->getRequest()->getMethod()) {
            $file = $event->getFile();
            $response = $event->getResponse();
            if($event->getRequest()->files->get('files')->getClientOriginalName()){
                if('attachment' == $event->getRequest()->get('type')){
                    $response['files'] = array(
                        array(
                            'original_name' => $event->getRequest()->files->get('files')->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'name' => $file->getFilename(),
                    ), );
                }else{
                    if ($event->getRequest()->get('private')) {
                        $private = true;
                    } else {
                        $private = false;
                    }
                    $oProject = $this->doctrine->getManager()->getRepository('WWSCThalamusBundle:Project')->find($event->getRequest()->get('project'));
                    $oCategory = $this->doctrine->getManager()->getRepository('WWSCThalamusBundle:Category')->find($event->getRequest()->get('category-file'));
                    $em = $this->doctrine->getManager();
                    $newFile = new Files();
                    $newFile->setName($event->getRequest()->files->get('files')->getClientOriginalName());
                    $newFile->setFileSrc($file->getFilename());
                    $newFile->setFileSize($file->getSize());
                    $newFile->setProject($oProject);
                    $newFile->setPrivate($private);
                    $newFile->setType('Project');
                    $newFile->setCategory($oCategory);
                    $newFile->setDescription($event->getRequest()->get('description'));
                    $em->persist($newFile);
                    $em->flush();
                    $response['files'] = array(
                        array(
                            'name' => $newFile->getName(),
                            'thumbnailUrl' => $newFile->getFileIcon(),
                            'url' => $newFile->getFileSrc(),
                            'id' => $newFile->getId(),
                    ), );
                }
            }
        }
    }
}
