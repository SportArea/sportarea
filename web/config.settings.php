<?php
$globalSettings['accountsSettings'] = array(
    'date_format'           => array(
        'title'             =>  'Format data',
        'description'       =>  'Formatul datei afisat in cadrul portalului',
        'type'              =>  'enum',
        'possible_values'   =>  '{"Y-m-d":"yyyy-mm-dd","Y.m.d":"yyyy.mm.dd","Y/m/d":"yyyy/mm/dd","d-m-Y":"dd-mm-yyyy","d.m.Y":"dd.mm.yyyy","d/m/Y":"dd/mm/yyyy"}',
        'value'             =>  'd/m/Y',
        'category_id'       =>  2
    ),
);

$globalSettings['uploadDirectories'] = array('documents', 'documents_templates', 'users', 'cases', 'tasks');

$globalSettings['uploadMaximumMBSize'] = min( abs(intval(ini_get('post_max_size'))), abs(intval(ini_get('upload_max_filesize'))) );

/**
 * User profile picture / Poza de profil a utilizatorului
 */
$globalSettings['profilePictureAcceptedFileTypes']['extensions']    =   array('png', 'jpg', 'jpeg');
$globalSettings['profilePictureAcceptedFileTypes']['mimetypes']     =   array('image/png', 'image/jpeg');

/**
 * Documents templates / Modele documente
 */
$globalSettings['documentsTemplatesAcceptedFileTypes']['extensions'] =   array('doc', 'docx');

/**
 * Documents / Documente
 */
$globalSettings['documentsAcceptedFileTypes']['extensions'] =   array('jpg', 'png', 'tif', 'pdf', 'doc', 'docx', 'odt');
