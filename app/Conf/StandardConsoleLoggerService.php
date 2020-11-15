<?php


namespace App\Conf;


use App\Contracts\Logger;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

class StandardConsoleLoggerService implements Logger
{

    private $loggingConsole;


    /**
     * StandardConsoleLoggerService constructor.
     * @param ConsoleOutput $loggingConsole
     */
    public function __construct(ConsoleOutput $loggingConsole)
    {
        $this->loggingConsole = $loggingConsole;
    }


    public function log($message, $level = 'debug')
    {
        if (env('CONSOLE_LOG', false)) {
            if (is_object($message)) {
                $message = json_encode('message');

            }
            $this->loggingConsole->writeln($message);
            Log::log($level, $message);
        }

    }
}
