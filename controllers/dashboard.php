<?php include_once(MODELS."/".$model."_model.php"); 

$WorkGroupName = $_SESSION['site']['pm_row']->WorkgroupName;
$WorkGroupID = $_SESSION['site']['pm_row']->WorkgroupID;


$objDash = new dashboard();


$RowGeneralMessage = $objDash->getAllMessageBoard();
$GeneralMessageBox = $objDash->displayMessageBoard($RowGeneralMessage);


$RowInternalMessage = $objDash->getAllMessageBoard($WorkGroupID);
$InternalMessageBox = $objDash->displayMessageBoard($RowInternalMessage,'int');


$objDash->getAllDocument();
$GeneralDocuments = $objDash->makeHierarchy('gen');

$objDash->getAllDocument($WorkGroupID);
$InternalDocuments = $objDash->makeHierarchy('int');

$RowAgenda = $objDash->getAllAgenda();
$strAgenda = $objDash->displayAgenda($RowAgenda);

?>


