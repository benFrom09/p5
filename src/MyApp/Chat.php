<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;




class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $room = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->room = [];
        echo 'Congratulation! The server is running\n';
        
    }
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        //var_dump($conn);
        echo "New connection!" . " id :" . $conn->resourceId. "\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $data = json_decode($msg);
        
        
       
       
        
        var_dump($this->connectionStatus($msg));
        
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
                , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        

        foreach($this->clients as $client) {
            if($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "someone has disconnected";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }


    private function connectionStatus($message) {
        $message = json_encode(['action' =>'status']);
    }
    
    
}





