<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $group = [];
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->group = [];
        echo 'Congratulation! The server is running\n';
        
    }
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        //var_dump($conn);
        echo "New connection!" . " id :" . $conn->resourceId. "\n";
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * 
     * @param ConnectionInterface $from
     * @param type $msg
     */
    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);
        var_dump($data);
        $action = $data->type;
        $group = isset($data->group) ? $data->group : "";
        
        if(($action === 'join') && $group){
            //subscribe user to group only if he hasn't subscribed
            
            //if group exist and user is yet to subscribe, then subscibe him to group
            //OR
            //if group does not exist, create it by adding user to it
            if((array_key_exists($group, $this->group) && !in_array($from, $this->group[$group])) || !array_key_exists($group, $this->group)){                
                if(isset($this->group[$group]) && count($this->group[$group]) >= 2){
                    //maximum number of connection reached
                    $msg_to_send = json_encode(['type'=>'fullRoom']);
                
                    $from->send($msg_to_send);
                }
                
                else{
                    $this->group[$group][] = $from;//subscribe user to group
                
                    $this->notifyUsersOfConnection($group, $from);
                }
            }
            
            else{
                //tell user he has subscribed on another device/browser
                $msg_to_send = json_encode(['type'=>'fullRoom']);
                
                $from->send($msg_to_send);
            }
        }
        
        //for other actions
        else if($group && isset($this->group[$group])){
            //send to everybody subscribed to the group received except the sender
            foreach($this->group[$group] as $client){
                if ($client !== $from) {
                    $client->send($msg);
                }
            }
        }
    }
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * 
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove connection
        $this->clients->detach($conn);
        
        if(count($this->group)){//if there is at least one group created
            foreach($this->group as $group=>$arr_of_subscribers){//loop through the group
                foreach ($arr_of_subscribers as $key=>$ratchet_conn){//loop through the users connected to each group
                    if($ratchet_conn == $conn){//if the disconnecting user subscribed to this group
                        unset($this->group[$group][$key]);//remove him from the group
                        
                        //notify other subscribers that he has disconnected
                        $this->notifyUsersOfDisconnection($group, $conn);
                    }
                }
            }
        }
    }
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * 
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {
        //echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * 
     * @param type $group
     * @param type $from
     */
    private function notifyUsersOfConnection($group, $from){
                        
        //echo "User subscribed to group ".$group ."\n";
        $msg_to_broadcast = json_encode(['type'=>'isNewUser', 'group'=>$group]);
        //notify user that someone has joined group
        foreach($this->group[$group] as $client){
            if ($client !== $from) {
                $client->send($msg_to_broadcast);
            }
        }
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    private function notifyUsersOfDisconnection($group, $from){
        $msg_to_broadcast = json_encode(['type'=>'Offline', 'group'=>$group]);
        //notify user that remote has left the group
        foreach($this->group[$group] as $client){
            if ($client !== $from) {
                $client->send($msg_to_broadcast);
            }
        }
    }
}
    
    

