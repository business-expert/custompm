<?php  include_once(MODELS_ADMIN."/".$model."_model.php"); 

$objDash = new dashboard();

$RowGeneralMessage = $objDash->getAllMessageBoard();
$GeneralMessageBox = $objDash->displayMessageBoard($RowGeneralMessage);

$RowInternalMessage = $objDash->getAllMessageBoard(-1);
$InternalMessageBox = $objDash->displayMessageBoard($RowInternalMessage);

$objDash->getAllDocument();
$GeneralDocuments = $objDash->makeHierarchy('gen');

$objDash->getAllDocument(-1);
$InternalDocuments = $objDash->makeHierarchy('int');

$RowAgenda = $objDash->getAllAgenda();
$strAgenda = $objDash->displayAgenda($RowAgenda);

?>


