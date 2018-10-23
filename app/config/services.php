<?php  

use Phalcon\Mvc\View; 
use Phalcon\Mvc\View\Engine\Php as PhpEngine; 
use Phalcon\Mvc\Url as UrlResolver; 
use Phalcon\Mvc\View\Engine\Volt as VoltEngine; 
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter; 
use Phalcon\Session\Adapter\Files as SessionAdapter; 
use Phalcon\Flash\Direct as Flash;   

/** 
   * Shared configuration service 
*/ 

$di->setShared('config', function () { 
   return include APP_PATH . "/config/config.php"; 
});  

/** 
   * The URL component is used to generate all kind of urls in the application 
*/ 

$di->setShared('url', function () { 
      $config = $this->getConfig(); 
      $url = new UrlResolver(); 
      $url->setBaseUri($config->application->baseUri);  
   return $url; 
});  

/** 
   * Setting up the view component 
*/ 
   
$di->setShared('view', function () { 
   $config = $this->getConfig();  
   $view = new View(); 
   $view->setDI($this); 
   $view->setViewsDir($config->application->viewsDir);  
   
   $view->registerEngines([ 
      '.volt' => function ($view) { 
         $config = $this->getConfig();  
         $volt = new VoltEngine($view, $this);  
         
         $volt->setOptions([ 
            'compiledPath' => $config->application->cacheDir, 
            'compiledSeparator' => '_' 
         ]);  
         return $volt; 
      }, 
      '.phtml' => PhpEngine::class  
   ]);  
   return $view; 
}); 

/** 
   * Database connection is created based in the parameters defined in the configuration 
      file 
*/ 

$di->setShared('db', function () { 
   $config = $this->getConfig();  
   $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter; 
   $connection = new $class([ 
      'host'     => $config->database->host, 
      'username' => $config->database->username, 
      'password' => $config->database->password, 
      'dbname'   => $config->database->dbname, 
      'charset'  => $config->database->charset 
   ]);  
   return $connection; 
});