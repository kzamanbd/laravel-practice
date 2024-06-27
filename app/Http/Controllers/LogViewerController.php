<?php

namespace App\Http\Controllers;

use App\Actions\LogViewer;

class LogViewerController extends Controller
{
    public function getLogFile(LogViewer $logViewer)
    {
        return $logViewer->getLogFile();
    }

    public function getLogDetail(LogViewer $logViewer, $file)
    {
        return $logViewer->getLogDetail($file);
    }
}
