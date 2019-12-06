<?php

use GroupDocs\Editor\Model;
use GroupDocs\Editor\Model\Requests;

// This example demonstrates how to edit presentation document
class EditPresentationDocument {
    public static function Run() {
        
        // Create necessary API instances
        $editApi = CommonUtils::GetEditApiInstance();
        $fileApi = CommonUtils::GetFileApiInstance();
        
        // The document already uploaded into the storage
        // Load it into editable state
        $fileInfo = new Model\FileInfo();
        $fileInfo->setFilePath("Presentation/with-notes.pptx");        
        $loadOptions = new Model\PresentationLoadOptions();
        $loadOptions->setFileInfo($fileInfo);
        $loadOptions->setOutputPath("output");
        $loadOptions->setSlideNumber(0);
        $loadResult = $editApi->load(new Requests\loadRequest($loadOptions));
        
        // Download html document
        $htmlFile = $fileApi->downloadFile(new Requests\downloadFileRequest($loadResult->getHtmlPath()));
        $html = file_get_contents($htmlFile->getRealPath());

        // Edit something...
        $html = str_replace("Slide sub-heading", "Hello world!", $html);

        // Upload html back to storage
        file_put_contents($htmlFile->getRealPath(), $html);
        $uploadRequest = new Requests\uploadFileRequest($loadResult->getHtmlPath(), $htmlFile->getRealPath());
        $fileApi->uploadFile($uploadRequest);

        // Save html back to pptx
        $saveOptions = new Model\PresentationSaveOptions();
        $saveOptions->setFileInfo($fileInfo);
        $saveOptions->setOutputPath("output/edited.pptx");
        $saveOptions->setHtmlPath($loadResult->getHtmlPath());
        $saveOptions->setResourcesPath($loadResult->getResourcesPath());
        $saveResult = $editApi->save(new Requests\saveRequest($saveOptions));

        // Done.
        echo "Document edited: " . $saveResult->getPath();
        echo "\n";                            
    }
}
