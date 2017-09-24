<?php

/*
Brasbip.com.br: envio de SMS coorporativo
Classe de implementação para PHP
Criada por Vinícius Lage
Versão 1.0 
Data 10/11/2010
*/

class BrasbipSMS
{
    //input parameters ---------------------
	var $usuario;                           //seu nome de usuário
	var $senha;                         	//sua senha
	var $sender;                            //remetente(NR)
	var $mensagem;                          //texto da mensagem
	var $flash;                             //flash (1 or 0)
	var $inputgsmnumbers;			        //números de destino, separados por vírgura
	var $tipo;                              //tipo da mensagem ("bookmark" - para wap push, "longSMS" para mensagem de texto normal)
	var $wapurl;                          	//wap url (examplo: www.brasbip.com.br)
	//--------------------------------------

	var $host;
	var $path;
	var $postData;
	var $response;


	// Método para envio de SMS
	function enviaSMS($username, $password, $sender, $message, $flash, $inputgsmnumbers, $type, $bookmark)
	{
		$this->host = "api.brasbip.com.br";
		$this->path = "/v1/enviaSMS.brasbip";
		
		$this->usuario			= $username;
		$this->senha 			= $password;
		$this->sender 			= htmlspecialchars($sender, ENT_QUOTES);
		$this->mensagem			= htmlspecialchars($message, ENT_QUOTES);
		$this->flash 			= $flash;
		$this->inputgsmnumbers 	= $inputgsmnumbers;
		$this->tipo 			= $type;
		$this->wapurl 			= $bookmark;

		$this->postData = $this->CriaPostData();
        $this->response = $this->Postar($this->path,$this->postData,$this->host);
        return $this->response;
	}	
	

	function CriaPostData(){
		return "gsm=".$this->inputgsmnumbers."&usuario=".$this->usuario."&senha=".$this->senha."&sender=".$this->sender."&isflash=".$this->flash."&tipoMsg=".$this->tipo."&wapurl=".$this->wapurl."&mensagem=".$this->mensagem;
	}
	
	

	// POST usando sockets
	// sockets precisam estar liberados no seu servidor
	// abra o php.ini
	// retire o ponto e vírgula antes de "extension=php_sockets.dll"
	
	function Postar($uri,$postdata,$host){
		
	   $response = "";
		
	   $da = fsockopen($host, 80, $errno, $errstr);
	   if (!$da) 
	   {
		   return "$errstr ($errno)";
	   }
	   else {
		   $saida ="POST $uri  HTTP/1.1\r\n";
		   $saida.="Host: $host\r\n";
		   $saida.="User-Agent: PHP Script\r\n";
		   $saida.="Content-Type: application/x-www-form-urlencoded\r\n";
		   $saida.="Content-Length: ".strlen($postdata)."\r\n";
		   $saida.="Connection: Keep-Alive\r\n\r\n";
		   $saida.=$postdata;
		   fwrite($da, $saida);
		   
		   while (!feof($da))  $response.=fgets($da, 128);
		   		   
		   $response=split("\r\n\r\n",$response);
		   $header=$response[0];
		   $responsecontent=$response[1];
		   
		   // Decodificando a resposta
		   if(!(strpos($header,"Transfer-Encoding: chunked")===false)){
			   $aux=split("\r\n",$responsecontent);
			   for($i=0;$i<count($aux);$i++)
				   if($i==0 || ($i%2==0))
					   $aux[$i]="";
			   $responsecontent=implode("",$aux);
		   }//if
		   return chop($responsecontent);
	   }//else
	}// Postar()
	
	
}// fim da classe

?>