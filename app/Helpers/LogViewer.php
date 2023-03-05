<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class LogViewer
{
    protected string $logsPath;
    protected string $regexLogs;
    protected string $regexEachLog;
    protected int $maxReadLength;
    protected string $logChannel;

    public function __construct()
    {
        $this->logsPath = storage_path('logs');
        $this->regexLogs = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/';
        $this->regexEachLog = '/^\[(\d{4}-\d{2}-\d{2}[T ]\d{2}:\d{2}:\d{2}\.?(\d{6}([\+-]\d\d:\d\d)?)?)\](.*?(\w+)\.|.*?)(debug|info|notice|warning|error|critical|alert|emergency|processing|processed|failed)?: (.*?)( in [\/].*?:[0-9]+)?$/is';
        $this->maxReadLength = 10000000;
        $this->logChannel = config('logging.default');
    }

    public function logFiles($using = 'glob')
    {
        if (!is_dir($this->logsPath)) {
            return 'logs - directory does not exist into the storage folder.';
        }
        if ($using == 'file') {
            $filesArr = self::fileNamesByFile($this->logsPath);
        } elseif ($using == 'scan') {
            $filesArr = self::fileNamesByScanDir($this->logsPath);
        } else {
            $filesArr = self::fileNamesByGlob($this->logsPath);
        }
        return self::createFileArr($this->logsPath, $using, $filesArr);
    }

    public static function createFileArr($path, $using = 'glob', $filesArr = [])
    {
        $logFiles = [];
        if (!empty($filesArr) && count($filesArr)) {
            if ($using == 'file') {
                foreach ($filesArr as $v) {
                    $arr = [];
                    $arr['name'] = $v->getFilename();
                    $arr['path'] = $v->getPathname();
                    $arr['size'] = $v->getSize();
                    $arr['readable_size'] = self::convertToReadableSize($arr['size']);
                    $arr['extension'] = $v->getExtension();
                    $arr['created_at'] = date('Y-m-d H:i:s', $v->getCTime());
                    $arr['updated_at'] = date('Y-m-d H:i:s', $v->getMTime());
                    $arr['is_readable'] = is_readable($arr['path']);
                    $logFiles[] = $arr;
                }
                if (!empty($logFiles[0]) && count($logFiles) > 1) {
                    $logFiles = array_reverse($logFiles);
                    $tempFile = $logFiles[0];
                    unset($logFiles[0]);
                    $logFiles[] = $tempFile;
                }
            } else {
                foreach ($filesArr as $v) {
                    $arr = [];
                    $pathInfo = pathinfo($v);
                    $arr['name'] = basename($v);
                    $arr['path'] = (!empty($pathInfo['dirname']) && $pathInfo['dirname'] == '.') ? $path . '/' . $v : $v;
                    $arr['size'] = filesize($arr['path']);
                    $arr['readable_size'] = self::convertToReadableSize($arr['size']);
                    $arr['extension'] = !empty($pathInfo['extension']) ? $pathInfo['extension'] : '';
                    $fileStats = stat($arr['path']);
                    $arr['created_at'] = !empty($fileStats['ctime']) ? date('Y-m-d H:i:s', $fileStats['ctime']) : '';
                    $arr['updated_at'] = !empty(filemtime($arr['path'])) ? date('Y-m-d H:i:s', filemtime($arr['path'])) : '';
                    $arr['is_readable'] = is_readable($arr['path']);
                    $logFiles[] = $arr;
                }
            }
        }
        return $logFiles;
    }

    public static function isLogsWritable(): bool
    {
        return is_writable(storage_path('logs'));
    }

    public static function logsPermission(): string
    {
        return substr(decoct(fileperms(storage_path('logs'))), -4);
    }

    public static function isFileExtensionEnabled(): bool
    {
        return extension_loaded('fileinfo');
    }

    public static function fileNamesByFile($dirPath): array
    {
        return File::files($dirPath);
    }

    public static function fileNamesByScanDir($dirPath = '')
    {
        $fileNamesArr = [];
        if (empty($dirPath)) {
            return 'logs - directory does not exist for scan.';
        }
        $scan = scandir($dirPath, SCANDIR_SORT_DESCENDING);
        if (!empty($scan)) {
            $count = 1;
            foreach ($scan as $v) {
                if (!is_dir($v) && $count <= 100) {
                    $ext = explode('.', $v);
                    if (!empty($ext)) {
                        if (!empty(end($ext)) && end($ext) == 'log') {
                            $fileNamesArr[] = $v;
                            $count++;
                        }
                    }
                }
            }
        }
        return self::resetFileNamesArr($fileNamesArr);
    }

    public static function fileNamesByGlob($dirPath = '')
    {
        if (empty($dirPath)) {
            return 'logs - directory does not exist for scan.';
        }
        $fileNamesArr = glob($dirPath . '/*.log');
        if (!empty($fileNamesArr) && count($fileNamesArr)) {
            $fileNamesArr = array_reverse($fileNamesArr);
            $fileNamesArr = array_slice($fileNamesArr, 0, 100);
        }
        return self::resetFileNamesArr($fileNamesArr);
    }

    public static function resetFileNamesArr($fileNamesArr = [])
    {
        if (!empty($fileNamesArr) && count($fileNamesArr)) {
            if (in_array('laravel.log', $fileNamesArr) && count($fileNamesArr) > 1 && $fileNamesArr[0] == 'laravel.log') {
                unset($fileNamesArr[0]);
                $fileNamesArr[] = 'laravel.log';
            }
            if (count($fileNamesArr) > 1 && !empty($fileNamesArr[0]) && strpos($fileNamesArr[0], 'laravel.log') !== false) {
                $tempFile = $fileNamesArr[0];
                unset($fileNamesArr[0]);
                $fileNamesArr[] = $tempFile;
            }
        }
        return $fileNamesArr;
    }

    public static function convertToReadableSize($size = null): string
    {
        if (empty($size)) {
            return '';
        }
        $base = log($size) / log(1024);
        $suffix = array("Byte", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . ' ' . $suffix[$f_base];
    }

    public function getLogFile(): array
    {
        $dataBag = [];
        $dataBag['is_logs_writable'] = self::isLogsWritable();
        $dataBag['logs_permission'] = self::logsPermission();

        if (self::isFileExtensionEnabled()) {
            $dataBag['log_files'] = $this->logFiles('file');
        } else {
            $dataBag['log_files'] = $this->logFiles();
        }
        $dataBag['log_channel'] = $this->logChannel;
        $dataBag['today_log'] = 'laravel-' . date('Y-m-d') . '.log';

        return $dataBag;
    }

    public function getLogDetail($file): array
    {
        $data = [];
        $data['is_filesize_over'] = false;
        $data['file_name'] = $file;

        abort_if(!file_exists($this->logsPath . '/' . $file), 404, 'Sorry! Log File Not Exist');

        if (fileSize($this->logsPath . '/' . $file) > $this->maxReadLength) {
            $data['is_filesize_over'] = true;
        }

        $logsData = [];
        $fileContent = file_get_contents($this->logsPath . '/' . $file);
        preg_match_all($this->regexLogs, $fileContent, $matches);

        if (!empty($matches[0]) && is_array($matches[0]) && count($matches[0])) {
            foreach ($matches[0] as $v) {
                preg_match($this->regexEachLog, $v, $extractLogs);
                if (!empty($extractLogs) && count($extractLogs)) {
                    $logsData[] = $extractLogs;
                }
            }
            if (!empty($logsData)) {
                $logsData = array_reverse($logsData);
            }
        }
        $data['logs_data'] = $logsData;

        return $data;
    }

    public function downloadLogs($file)
    {
        if (empty($file)) {
            return back();
        }

        if (!file_exists($this->logsPath . '/' . $file)) {
            abort(404, 'Sorry! Log File Not Exist');
        }

        $headers = [
            'Content-Type: text/plain',
            'Content-Disposition' => 'attachment; filename="' . $file . '"',
        ];

        if (function_exists('response')) {
            return response()->download($this->logsPath . '/' . $file, $file, $headers);
        }

        return app('\Illuminate\Support\Facades\Response')->download($this->logsPath . '/' . $file, $file, $headers);
    }

    public function clearLogs($file)
    {
        if (empty($file)) {
            return back();
        }

        if (!file_exists($this->logsPath . '/' . $file)) {
            abort(404, 'Sorry! Log File Not Exist');
        }

        file_put_contents($this->logsPath . '/' . $file, "");

        return back()->with('success_msg', $file . ' - logs has been cleared successfully');
    }

    public function deleteLogs($file)
    {
        if (empty($file)) {
            return back();
        }

        if (!file_exists($this->logsPath . '/' . $file)) {
            abort(404, 'Sorry! Log File Not Exist');
        }

        unlink($this->logsPath . '/' . $file);

        return back()->with('success_msg', $file . ' - logs has been deleted successfully');
    }
}
