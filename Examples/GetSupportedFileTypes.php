<?php

// This example demonstrates how to obtain all supported file types.
class GetSupportedFileTypes {
    public static function Run() { 
        $infoApi = CommonUtils::GetInfoApiInstance();

        $response = $infoApi->getSupportedFileFormats();
        
        foreach ($response->getFormats() as $key => $format) {
            echo $format->getFileFormat() . " - " . $format->getExtension() . "\n";
        }                        
    }
}
