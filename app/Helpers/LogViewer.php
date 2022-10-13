<?php

/**
 ** @Author: Kamruzzaman 
 * @Date: 2022-10-13 23:48:12 
 * @Last Modified by: Kamruzzaman
 * @Last Modified time: 2022-10-14 00:28:34
 */

namespace App\Helpers;


class LogViewer
{
    protected $final = [];
    protected $config = [];


    public function __construct($config = [])
    {
        if (array_key_exists('date', $config)) {
            $this->config['date'] = $config['date'];
        } else {
            $this->config['date'] = null;
        }
    }


    public function getLogFileDates()
    {
        $dates = [];
        $files = glob(storage_path('logs/laravel*.log'));
        $files = array_reverse($files);
        foreach ($files as $path) {
            $fileName = basename($path);
            preg_match('/(?<=laravel)(.*)(?=.log)/', $fileName, $dtMatch);
            $date = $dtMatch[0];
            array_push($dates, $date);
        }

        return $dates;
    }

    public function getLog()
    {
        $availableDates = $this->getLogFileDates();

        if (count($availableDates) == 0) {
            return response()->json([
                'success' => false,
                'message' => 'No log file available'
            ]);
        }

        $configDate = $this->config['date'];
        if ($configDate == null) {
            $configDate = $availableDates[0];
        }

        if (!in_array($configDate, $availableDates)) {
            return response()->json([
                'success' => false,
                'message' => 'No log file found with selected date ' . $configDate
            ]);
        }


        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<message>.*)/m";

        $fileName = 'laravel.log';
        $content = file_get_contents(storage_path('logs/' . $fileName));
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

        $logs = [];
        foreach ($matches as $match) {
            $logs[] = [
                'env' => $match['env'],
                'type' => $match['type'],
                'timestamp' => $match['date'],
                'message' => trim($match['message'])
            ];
        }

        preg_match('/(?<=laravel)(.*)(?=.log)/', $fileName, $dtMatch);
        $date = $dtMatch[0];

        $data = [
            'available_log_dates' => $availableDates,
            'date' => $date,
            'filename' => $fileName,
            'logs' => collect($logs)->reverse()->values()->all()
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}
