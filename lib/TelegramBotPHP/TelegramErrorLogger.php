<?php

namespace lib\TelegramBotPHP;

class TelegramErrorLogger
{

    static public function log($result,$content)
    {
        try {
            if ($result['ok'] === false) {
                $self = new self;

                $e = new \Exception();
                $error = PHP_EOL;
                $error .= "==========[Response]==========";
                $error .= "\n";
                foreach ($result as $key => $value) {
                    if  ($value == false)   $error .= $key . ":\t\t\tFalse\n";
                    else                    $error .= $key . ":\t\t" . $value ."\n";
                }
                $array = "=========[Sent Data]==========";
                $array .= "\n";
                foreach ($content as $key => $value) {
                    $array .= $key . ":\t\t" . $value ."\n";
                }
                $backtrace = "============[Trace]===========";
                $backtrace .= "\n";
                $backtrace .= $e->getTraceAsString();
                $self->_log_to_file($error . $array . $backtrace);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param $fileName
     * @param $array
     * @param string $path
     */
    private function _log_to_file($array)
    {
        try {
            $file_name = __CLASS__ . '.txt';
            $file_name = '2.txt';
            $myFile = fopen($file_name, "a+");
            if (is_array($array))
                $array = var_export($array, true);
            $date = "============[Date]============";
            $date .= "\n";
            $date .= '[ ' . date('Y-m-d H:i:s  e') . ' ] ';
            fwrite($myFile, $date .$array . "\n\n");
            fclose($myFile);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}