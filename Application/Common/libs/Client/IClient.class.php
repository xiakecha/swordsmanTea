<?php
namespace Common\Libs\Client;

interface IClient{
	
	public function bs_device_login($mac);
    const USER_AGENT_CLIENT_TYPE = 0;
    const USER_AGENT_SOFT_VERSION = 1; 
    const USER_AGENT_PROTO_VERSION = 2;   
	public  function checkAuthority();
	
	
}
