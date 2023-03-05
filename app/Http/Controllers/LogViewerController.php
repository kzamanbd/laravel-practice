<?php

namespace App\Http\Controllers;

use App\Services\LogViewer;

class LogViewerController extends Controller
{
    protected LogViewer $logViewer;

    public function __construct(LogViewer $logViewer)
    {
        $this->logViewer = $logViewer;
    }

    public function getLogFile()
    {
        return $this->logViewer->getLogFile();
    }

    public function getLogDetail($file)
    {
        return $this->logViewer->getLogDetail($file);
    }
}
