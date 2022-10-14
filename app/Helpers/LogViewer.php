<?php

/**
 ** @Author: Kamruzzaman
 * @Date: 2022-10-13 23:48:12
 * @Last Modified by: Kamruzzaman
 * @Last Modified time: 2022-10-14 00:28:34
 */

namespace App\Helpers;


use Illuminate\Http\JsonResponse;

class LogViewer
{
    protected array $final = [];
    protected array $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (array_key_exists('file', $config)) {
            $this->config['file'] = $config['file'];
        } else {
            $this->config['file'] = null;
        }
    }

    /**
     * @return array
     */

    public function getLogFile(): array
    {
        $files = glob(storage_path('logs/laravel*.log'));
        $files = array_reverse($files);

        return array_map(function ($file) {
            return basename($file);
        }, $files);
    }

    public function getLog(): JsonResponse
    {
        $availableFiles = $this->getLogFile();

        if (count($availableFiles) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'No log file available'
            ]);
        }

        $requestFile = $this->config['file'];
        if ($requestFile == null) {
            $requestFile = $availableFiles[0];
        }

        if (!in_array($requestFile, $availableFiles)) {
            return response()->json([
                'success' => false,
                'message' => 'No log file found with selected date ' . $requestFile
            ]);
        }


        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";

        $fileName = $requestFile;
        $content = file_get_contents(storage_path('logs/' . $fileName));
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

        $logs = array_map(function ($match) {
            return [
                'env' => $match['env'],
                'type' => $match['type'],
                'timestamp' => $match['date'],
                'message' => trim($match['message'])
            ];
        }, $matches);

        preg_match('/(?<=laravel)(.*)(?=.log)/', $fileName, $dtMatch);
        $date = $dtMatch[0];

        $data = [
            'available_log_files' => $availableFiles,
            'filename' => $fileName,
            'logs' => collect($logs)->reverse()->values()->all()
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}
