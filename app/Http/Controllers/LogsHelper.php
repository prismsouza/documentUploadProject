<?php

function storeLog($masp, $document_id, $action, $is_document)
{
    $newlog = new App\Log();
    $newlog->user_masp = $masp;
    if ($is_document == 1) {
        $newlog->document_id = $document_id;
        $newlog->boletim_id = NULL;
    } elseif ($is_document == 0) {
        $newlog->document_id = NULL;
        $newlog->boletim_id = $document_id;
    }

    $newlog->action = $action;
    $newlog->save();
}
