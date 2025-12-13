<?php
namespace App\Command;
use App\WebSocket\WebSocketServer;
use Symfony\Component\Console\Command\Command; 
use Symfony\Component\Console\Input\InputArgument; 
use Symfony\Component\Console\Input\InputInterface; 
use Symfony\Component\Console\Input\InputOption; 
use Symfony\Component\Console\Output\OutputInterface; 

class WebSocketServerCommand extends Command 
{ 
    
    private WebSocketServer $wsServer; 
    
    public function __construct(WebSocketServer $wsServer){ 
        
        parent::__construct(); 
        $this->wsServer = $wsServer; 
    } 
    
    protected function configure() { 
        
        $this 
            ->setName('websocket:server') 
            ->setDescription('Starts the WebSocket server')
            ->addArgument('action', InputArgument::OPTIONAL, 'Action: (default: start)', 'start'); 
        } 
        
    protected function execute(InputInterface $input, OutputInterface $output): int { 
        
        $action = $input->getArgument('action'); 
        
        global $argv; 
        $argv[0] = 'bin/console'; 
        $argv[1] = $action; 
        
        $output->writeln("WebSocket server: $action");
        
        $this->wsServer->run(); 
        return Command::SUCCESS; 
    } 

}