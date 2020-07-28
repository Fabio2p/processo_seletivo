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
use MicrosoftAzure\Storage\Blob\Models\CreateBlobOptions;

class  ApiImagesBlobAzure{

	private $typeMime 	= null;

	private $nameImage 	= null;

	private $path		= null;

	private $size       = null;

	private $objConect 	= null;


	public function __construct(){

		$this->objConect = ServicesBuilder::getInstance()->createBlobService("DefaultEndpointsProtocol=https;AccountName=sdbusinessdrive;AccountKey=8W2DwJM491jq5jseno6z1Vm9m8Qw15d0JLdhENsVuyWYwV690jUjKePFdiagZyO6uN4RHC9cW1UofAWkBn99DA==");


	}

	
	public function getNameImage($name)
	{

		$this->nameImage 	= $_FILES["{$name}"]["name"];

	
		$extension 			= array('bmp' ,'png', 'svg', 'jpeg','txt');

		
		$allowed_extension  = explode('.', $this->nameImage);


		$search_eextension 	= strtolower(end($allowed_extension));
		 

		 $renameImages = strrchr($this->nameImage, '.'); 
		
		 
		 $image = time().uniqid(md5(true)).$renameImages;

		
		if (in_array($search_eextension, $extension) === true):

		   
		   //return $this->nameImage;

			return $image;
		
		else:
		
		    echo 'Tipo de imagem/Arquivo nao permitido!';

			
			exit;

		endif;


	}

	

	public function getPathTmpImages($directory_tmp)
	{

		$this->path = $_FILES["{$directory_tmp}"]["tmp_name"];

		return $this->path;

	}


	public function mimeTypeImage($type_mages){


		$this->typeMime = $_FILES["{$type_mages}"]["type"];

		
		return $this->typeMime;

	}


	public function getSizeImage($size_image){

		
		$size_max = 2000;


		$this->size = $_FILES["{$size_image}"]["size"];

		if($this->size <= $size_max):

			return $this->size;

		else:

			echo "Imagem acima de 2mb!";

		endif;

	}


	function apiUploadImagesBlobAzure($nomeDiretorio, $image, $path, $mimeImage)
	{
		

    	 $upload = fopen($path, "r");

    	
    	 $mimeType = new createbloboptions();

        
         $mimeType->setContentType("{$mimeImage}");


	     $this->objConect->createBlockBlob($nomeDiretorio, $image, $upload, $mimeType);
	     
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
