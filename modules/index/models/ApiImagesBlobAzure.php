<?php
require_once'vendor/autoload.php';

use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\PageRange;
use MicrosoftAzure\Storage\Blob\Models\ListPageBlobRangesOptions;
use MicrosoftAzure\Storage\Blob\Models\GetBlobOptions;
use MicrosoftAzure\Storage\Blob\Models\DeleteBlobOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


class  ApiImagesBlobAzure{

	private $objConect = null;

	public function __construct(){

		$this->objConect = ServicesBuilder::getInstance()->createBlobService("DefaultEndpointsProtocol=https;AccountName=sdbusinessdrive;AccountKey=8W2DwJM491jq5jseno6z1Vm9m8Qw15d0JLdhENsVuyWYwV690jUjKePFdiagZyO6uN4RHC9cW1UofAWkBn99DA==");
	}


	function apiUploadImagesBlobAzure($nomeDiretorio, $image, $path)
	{
		

    	$upload = fopen($path, "r");


	    $this->objConect->createBlockBlob($nomeDiretorio, $image, $upload);
	     
	}

	public function listImagesBlobAzure($nomeDiretorio){
		
		try {
		
			$listBlobsResult = $this->objConect->listBlobs($nomeDiretorio);

		    foreach ($listBlobsResult->getBlobs() as $blob):

		      	//echo "Listagem de Imagem: ".$blob->getName() .'<br> Url: '. $blob->getUrl()."<br />";

		    	echo "<img src=".$blob->getUrl()." width='400'>";
		    	
		    endforeach;

		}catch(ServiceException $e){
			  
			  $code = $e->getCode();
			  
			  $error_message = $e->getMessage();
			  
			  echo $code.": ".$error_message."<br />";
			}

	}

}
