<?php

namespace WWSC\ThalamusBundle\Service;

trait DebugFileLogTrait {

    /**
     * Saving debug info to file
     * @param $debug
     */
    public function debugToFile($debug)
    {
        $file = 'debug.log';
        file_put_contents($file, $debug);
    }
    
}