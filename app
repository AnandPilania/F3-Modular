#!/usr/bin/env php

<?php

class App {

    public function __construct($args) {
        $this->args = $args;
    }

    public function help() {
        echo "\n";
        echo "Syntax: php app <command> [<args>]".PHP_EOL;
        echo PHP_EOL;
        echo "Commands: \n";
        echo "php app --help                  -->   Displays the help menu.".PHP_EOL;
        echo "php app generate                -->   Generate SECRET key.".PHP_EOL;
        echo "php app serve                   -->   Start WebServer.".PHP_EOL;
        echo "php app serve --port            -->   Start WebServer to specific port.".PHP_EOL;
        echo PHP_EOL;
    }

    public function run() {
        if (count($this->args) <= 1) {
            $this->help();
        } else {
            switch ($this->args[1]) {
				case "generate":
					$this->generateKey();
					break;
                case "serve":
                    $this->serve();
                    break;
                case "help":
                case "--help":
                    $this->help();
                    break;
				default:
					$this->error();
            }
        }
    }

    private function serve() {
        $command = 'php -S';
        $ip = '127.0.0.1';
        $port = 8888;
        $dir = './';

        foreach($this->args as $key => $arg) {
            $arg = strtolower($arg);
            if($arg === 'ip' || $arg === '--ip'){
                $host = $this->args[++$key];
                if(
                    (is_numeric($host) && !filter_var($host, FILTER_VALIDATE_IP))
                    ||
                    (is_string($host) && strtolower($host) !== 'localhost')
                ){
                    $this->error($arg.': '.$host.' must be localhost OR an valid IP!');
                    break;
                }
                $ip = $host;
            }
            if($arg === 'port' || $arg === '--port'){
                $port = $this->args[++$key];
            }
            if($arg === 'dir' || $arg === '--dir'){
                $dir = $this->args[++$key];
            }
        }

        echo "Served as {$ip}:{$port} to {$dir}";
        $started = exec($command.' '.$ip.':'.$port.' -t '.$dir);
        $this->error($started);
    }

	private function generateKey() {
		$cipher = 'AES-256-CBC';
		echo 'base64:'.base64_encode(random_bytes($cipher == 'AES-128-CBC' ? 16 : 32));
	}

    private function error($msg = null) {
		if($msg){
            echo "\t{$msg}";
            exit();
        }

        echo "\nSupplied argument/s is not supported:\n";
		foreach($this->args as $arg) {
			if($arg == 'app') { continue; }
			echo "\t";
			echo "{$arg}";
			echo "\n";
		}

        echo PHP_EOL;
	}
}

$app = new App($argv);
$app->run();