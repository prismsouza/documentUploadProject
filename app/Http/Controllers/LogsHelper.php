<?php

function storeLog($masp, $document_id, $action)
{
    $newlog = new App\Log();
    $newlog->user_masp = $masp;
    $newlog->document_id  = $document_id;
    $newlog->action = $action;
    $newlog->save();
}
