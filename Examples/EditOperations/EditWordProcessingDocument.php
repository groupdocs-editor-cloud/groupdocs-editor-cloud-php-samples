<?php

use GroupDocs\Editor\Model;
use GroupDocs\Editor\Model\Requests;

// This example demonstrates how to edit word processing document
class EditWordProcessingDocument {
    public static function Run() {
        
        // Create necessary API instances
        $editApi = CommonUtils::GetEditApiInstance();
        $fileApi = CommonUtils::GetFileApiInstance();
        
        // The document already uploaded into the storage
        // Load it into editable state
        $fileInfo = new Model\FileInfo();
        $fileInfo->setFilePath("WordProcessing/password-protected.docx");
        $fileInfo->setPassword("password");
        $loadOptions = new Model\WordProcessingLoadOptions();
        $loadOptions->setFileInfo($fileInfo);
        $loadOptions->setOutputPath("output");
        $loadResult = $editApi->load(new Requests\loadRequest($loadOptions));
        
        // Download html document
        $htmlFile = $fileApi->downloadFile(new Requests\downloadFileRequest($loadResult->getHtmlPath()));
        $html = file_get_contents($htmlFile->getRealPath());

        // Edit something...
        $html = str_replace("Sample test text", "Hello world", $html);

        // Upload html back to storage
        file_put_contents($htmlFile->getRealPath(), $html);
        $uploadRequest = new Requests\uploadFileRequest($loadResult->getHtmlPath(), $htmlFile->getRealPath());
        $fileApi->uploadFile($uploadRequest);

        // Save html back to docx
        $saveOptions = new Model\WordProcessingSaveOptions();
        $saveOptions->setFileInfo($fileInfo);
        $saveOptions->setOutputPath("output/edited.docx");
        $saveOptions->setHtmlPath($loadResult->getHtmlPath());
        $saveOptions->setResourcesPath($loadResult->getResourcesPath());
        $saveResult = $editApi->save(new Requests\saveRequest($saveOptions));

        // Done.
        echo "Document edited: " . $saveResult->getPath();
        echo "\n";                            
    }
}
