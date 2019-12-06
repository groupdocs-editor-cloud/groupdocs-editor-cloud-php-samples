<?php
// Required dependencies and include autoload.php
require_once(__DIR__ . '\vendor\autoload.php');

include(__DIR__ . '\CommonUtils.php');
include(__DIR__ . '\GetSupportedFileTypes.php');
include(__DIR__ . '\GetDocumentInformation.php');
include(__DIR__ . '\EditOperations\EditWordProcessingDocument.php');
include(__DIR__ . '\EditOperations\EditSpreadsheetDocument.php');
include(__DIR__ . '\EditOperations\EditPresentationDocument.php');
include(__DIR__ . '\EditOperations\EditDsvDocument.php');
include(__DIR__ . '\EditOperations\EditTextDocument.php');


// Uploading sample files into storage
CommonUtils::UploadResources();

// Get all supported file types
GetSupportedFileTypes::Run();

// Get document info
GetDocumentInformation::Run();

// Edit word processing document
EditWordProcessingDocument::Run();

// Edit spreadsheet document
EditSpreadsheetDocument::Run();

// Edit presentation document
EditPresentationDocument::Run();

// Edit DSV (Delimiter-separated values) document
EditDsvDocument::Run();

// Edit text document
EditTextDocument::Run();
