install bitrix code <br>
<code>
#/usr/bin/php
use Bitrix\Main\{Data\Cache, IO\File, Web\HttpClient};
$cache = Cache::createInstance(); $cacheId = 'gh_func'; $cacheDir = '/gh/'; $local = $_SERVER['DOCUMENT_ROOT'].'/finit.php';
if($cache->initCache(86400, $cacheId, $cacheDir)){include($cache->getVars()['file']);}elseif($cache->startDataCache()){  
    try{
        if(!is_dir($cachePath = rtrim($_SERVER['DOCUMENT_ROOT'], '/').'/bitrix/cache/'.SITE_ID.$cacheDir)){mkdir($cachePath, 0755, true);}
        $file = $cachePath.$cache->getPath($cacheId); 
        $code = (new HttpClient(['socketTimeout' => 5]))->get('https://raw.githubusercontent.com/ahilespelid/functions/bitrix/init.php');
        if($code && File::putFileContents($file, $code)){ 
            if(strpos($shell = shell_exec('php -l '.escapeshellarg($file).' 2>&1'), 'No syntax errors detected') !== false){
                $cache->endDataCache(['file' => $file]); 
                if(!file_exists($local)){file_put_contents($local, $code);}
                include($file);
            }else{unlink($file);}}}catch(Exception $e){$cache->abortDataCache();if(file_exists($local)){@include($local);}}}
</code>
<br>or<br>
<code>
#/usr/bin/bash
git clone https://github.com/ahilespelid/functions.git
</code>
<br>
<code>
#/usr/bin/php
if(file_exists($ff = \_\_DIR\_\_.'/functions/init.php')){require_once $ff;}
</code>
<br>
<code>
#/usr/bin/php
spl_autoload_register(function($class){
    $exp = explode('\\', $class); $namespace = strtolower($exp[0]); $class = $exp[1];  
    if('service' == $namespace && in_array(count($exp), [2,3])){
        if('Traits' == $class){$namespace = 'trait'; $class = $exp[2];}
        include_once($p = \_\_DIR\_\_.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$class.'.php'); 
}});
</code>
