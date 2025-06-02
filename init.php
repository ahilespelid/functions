<?php
//------------------------------------------------------------------------------CONST------------------------------------------------------------------------------------------------------------------------------------//  
if(!defined('DS')){define('DS', DIRECTORY_SEPARATOR);}
//------------------------------------------------------------------------------DEBUG------------------------------------------------------------------------------------------------------------------------------------//  
///*/ Функция дампа переменной авторская ///*/
if(!function_exists('pa')){
    function pa($a, $mes='', $br=0, $t='pre'):bool{
        $backtrace = debug_backtrace(); $fileinfo = ''; $sbr='';
        $fileinfo = (!empty($backtrace[0]) && is_array($backtrace[0])) ? $backtrace[0]['file'].':'.$backtrace[0]['line'] : '';
        while($br){$sbr.='<br>'; $br--;}
        echo '<div>'.$fileinfo.'</div>'.$sbr.'<div>'.$mes.'</div>'.'<'.$t.'>'; print_r($a = (!empty($a) ? $a : [])); echo '</'.$t.'>'.PHP_EOL;
return true;}}
///*/ Функция дампа переменной аналог laravel ///*/
if(!function_exists('dd')){
    function dd($a,$br=0,$mes='',$t='pre'):bool{$backtrace = debug_backtrace(); $fileinfo = '';$sbr='';
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        foreach($backtrace as $trace){
            $caller = $trace;
            $file = $caller['file'];
            $line = $caller['line'];
            $function = $caller['function'];
            $class = isset($caller['class']) ? $caller['class'] : '';
            echo "File: $file" . PHP_EOL;
            echo "Line: $line" . PHP_EOL;
            echo "Function: $function" . PHP_EOL;
            echo "Class: $class" . PHP_EOL;
            echo '<br><br>';}
        foreach($args as $arg){var_dump($arg);}        
        echo $fileinfo.$sbr.$mes.(empty($t) ? '' : '<'.$t.'>'); print_r($a=(!empty($a)?$a:[])); echo(empty($t) ? '' : '</'.$t.'>').PHP_EOL;
return null; exit;}}
///*/ Функция поиска места определения функции по имени функции ///*/
if(!function_exists('sf')){function sf($function_name, $print = 1){
    $backtrace = debug_backtrace(); $fileinfo = ''; $sbr='';
    $fileinfo = (!empty($backtrace[0]) && is_array($backtrace[0])) ? $backtrace[0]['file'].':'.$backtrace[0]['line'] : '';
    $ret = 'don`t search';
    if(in_array(strtolower($function_name), get_defined_functions()['user'])){
        $reflFunc = new ReflectionFunction("{$function_name}");
        $ret = (empty($reflFunc->getFileName())) ? $ret : $reflFunc->getFileName() . ':' . $reflFunc->getStartLine();}
    if($print){echo '<div>'.$fileinfo.'</div>'.'<div>'.$ret.'</div>';}else{return $ret;}
return null;}}
///*/ Функция поиска имени функции из списка определённых функций ///*/
if(!function_exists('lf')){function lf($function_name = ''){
    foreach($user_f = get_defined_functions()['user'] as $key => $word){
        if(!empty(strpos($word, $function_name))){$ret[sf($word,0)] = $word;}}
return (empty($ret)) ? $user_f : (ksort($ret) ? $ret : false);}}
///*/ Функция возвращает всё обьявленное в пространстве///*/
if(!function_exists('get_namespace')){function get_namespace($namespace = ''){
    $namespace.= '\\';
    $classes   = array_values(array_filter($dC = get_declared_classes(), fn($i) => strtolower(substr($i, 0, strlen($namespace))) === strtolower($namespace)));
return (empty($classes)) ? $dC : $classes;}}

//------------------------------------------------------------------------------ARRAY------------------------------------------------------------------------------------------------------------------------------------//  
///*/ Функция выбора уникальных ключей из массива ///*/
if(!function_exists('array_unique_key')){
function array_unique_key($array, $key){ 
    $ret = $key_array = []; $i = 0; 
    foreach($array as $val){if(!in_array($val[$key], $key_array)){$key_array[$i] = $val[$key];$ret[$i] = $val;} $i++;} 
return $ret;}}
///*/ ahilespelid функция рекурсивно чистит массив от битрикс сорных ключей начинающихся с тильды ~///*/
if(!function_exists('array_keys_clear_tilda')){function array_keys_clear_tilda(array $arBitrix){
    foreach($arBitrix as $k => $v){
        if('~' === substr($k, 0, 1)){unset($arBitrix[$k]);}else{$arBitrix[$k] = (is_array($v)) ? array_keys_clear_tilda($v) : $v;}}
return $arBitrix;}}
///*/ функция фильтрует массив по ключам начинающихся c $needle///*/
if(!function_exists('array_keys_starts_with')){function array_keys_starts_with(array $array, string $needle):?array{
    $ret = array_filter($array, function($v, $k) use($needle) {return strpos(strtolower($k), strtolower($needle)) === 0;}, ARRAY_FILTER_USE_BOTH);
return (empty($ret)) ? null : $ret;}}
///*/ функция объединяет любое количество массивов с сохранением структур и значений///*/
if(!function_exists('array_merge_save')){function array_merge_save(...$arrays){
    return array_reduce($arrays, function($c, $i){ 
        return array_reduce(array_keys($i ?? []), function($c, $k) use ($i){
            return $c + [$k => $c[$k] ?? [] + [$i[$k]]];}, $c);}, []);
}} /* $payload = (function_exists('array_merge_save')) ? array_merge_save($_REQUEST_JSON, $_GET, $_POST) : array_merge($_POST, $_GET, $_REQUEST_JSON); */
///*/ функция разглаживает многомерный ассоциативный массив в одномерный с точками в ключах///*/
if(!function_exists('array_flatten')){function array_flatten($array, $prefix = ''){
    $ret = [];foreach($array as $k => $v){
        $cur_k = is_string($k) ? ($prefix !== '' ? $prefix.'.'.$k : $k) : $prefix;
        if(is_array($v)){$ret = array_merge($ret, array_flatten($v, $cur_k));}else
        if(is_string($k)){$ret[$cur_k] = $v;}else
        if($cur_k !== ''){$ret[$cur_k] = $v;}}
return $ret;}}
//------------------------------------------------------------------------------FILE-SYSTEM------------------------------------------------------------------------------------------------------------------------------//  
///*/ ahilespelid Метод возвращает путь до папки local/php_interface Bitrix при учёте что текущий файл лежит в local/php_interface///*/ 
if(!function_exists('functions_path')){function functions_path(string $file=''){
    $ret = __DIR__;
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод возвращает путь до папки local/php_interface Bitrix при учёте что текущий файл лежит в local/php_interface///*/ 
if(!function_exists('interface_path')){function interface_path(string $file=''){
    $ret = dirname(functions_path());
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод возвращает путь до папки local Bitrix при учёте что текущий файл лежит в local/php_interface///*/ 
if(!function_exists('local_path')){function local_path(string $file=''){
    $ret = dirname(interface_path());
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод возвращает путь до папки resource_path Bitrix при учёте что текущий файл лежит в local/php_interface///*/ 
if(!function_exists('resource_path')){function resource_path(string $file=''){
    $ret = interface_path('resource');
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод возвращает путь до папки img_path ///*/ 
if(!function_exists('img_path')){function img_path(string $file=''){
    $ret = resource_path('img');
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод кодирует картинку в base64 ///*/ 
if(!function_exists('img_base64')){function img_base64(string $file, string $type = ''){
    if(empty($file = img_path($file))){return null;}else{
        $mime = (empty($type)) ? getimagesize($file)['mime'] : $type;
        $ret  = 'data:'.$mime.';base64,'.base64_encode(file_get_contents($file));
    }
return $ret;}}

///*/ ahilespelid Метод возвращает svg код из картинки svg ///*/ 
if(!function_exists('svg')){function svg(string $file, string $default = null, $attr = []): string {
    $svg = (empty($file = img_path($file))) ? $default ?? '<svg class="text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' : file_get_contents($file); 
    $replace = fn($carry, $k) => $k === 'style' 
        ? (preg_replace("/style=\"[^\"]*\"/i", "style=\"{$attr[$k]}\"", $carry) 
            ?: str_replace('<svg', "<svg style=\"{$attr[$k]}\"", $carry))
        : (preg_replace("/$k=\"[^\"]*\"/i", "$k=\"{$attr[$k]}\"", $carry) 
            ?: str_replace('<svg', "<svg $k=\"{$attr[$k]}\"", $carry));
return array_reduce(array_keys($attr), $replace, $svg);}}

//------------------------------------------------------------------------------IS-CONDITIONS----------------------------------------------------------------------------------------------------------------------------//  
///*/ Функция проверка строки на дату ///*/
if(!function_exists('is_date')){
function is_date($d){
    if(empty($d)){return null;}
    try{$date = new \DateTime($d);}catch(\Exception $e){return null;}
return $date;}}
///*/ahilespelid Проверка на мобильный телефон///*/
if(!function_exists('is_phone')){function is_phone(string $s, int $minDigits = 10, int $maxDigits = 14){
    $s = str_replace(['+', '(', ')', '-', ' '], '', $s);
return (preg_match('/^[7|8][0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s)) ? $s : null;}}
///*/ahilespelid Проверка строки на email///*/
if(!function_exists('is_email')){function is_email(string $email){return (false !== filter_var($email, FILTER_VALIDATE_EMAIL)) ? $email : null;}}
///*/ Фукция проверяет строку на json ///*/
if(!function_exists('is_json')){function is_json($json){
    $decoded = @json_decode($json);
return \JSON_ERROR_NONE === json_last_error() ? json_encode($decoded, \JSON_FORCE_OBJECT) : null;}}
///*/ Фукция проверяет переменную на true ///*/
if(!function_exists('is_true')){function is_true($bool){
    $ret = (true === is_bool($bool) && true === $bool) ? true : false;
return $ret;}}///*/ Фукция проверяет переменную на false ///*/
if(!function_exists('is_false')){function is_false($bool){
    $ret = (true === is_bool($bool) && false === $bool) ? true : false;
return $ret;}}

//------------------------------------------------------------------------------STRING-----------------------------------------------------------------------------------------------------------------------------------//  
///*/Функция переводит кирилицу в транслит///*/
function translit(string $t){
    $converter = ['а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'];
return strtr($t, $converter);}
///*/ Функция разбивает строку по разделителям переданным в массиве///*/
if(!function_exists('mexplode')){function mexplode(array $delimiters, string $string){
    $chr = '::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::';
return explode($chr, str_replace($delimiters, $chr, $string));}}
///*/ Функция переводчик google///*/
if(!function_exists('google_translate')){function google_translate($text, $from_lan = 'ru', $to_lan = 'en', $key = 'AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw'){
    $obj = json_decode(file_get_contents('https://translation.googleapis.com/language/translate/v2?q='.urlencode($text).'&source='.$from_lan.'&target='.$to_lan .'&format=text&key='.$key), true);
    $ret = trim($obj['data']['translations']['0']['translatedText']);
return (empty($ret)) ? false : $ret;}}

//------------------------------------------------------------------------------STRING-GENERATORS------------------------------------------------------------------------------------------------------------------------//  
///*/ Функция генерирует случайный префикс из ascii таблицы///*/
if(!function_exists('prefix')){function prefix(int $length = 5, bool $upcase = true, array $simbols = []){
    $simbols = (empty($simbols)) ? ($upcase ? array_merge(range(48, 57),range(65, 90)) : array_merge(range(48, 57),range(65, 90),range(97, 122))): $simbols;
    $length  = (empty($simbols)) ? $c : (($length > $c = count($simbols)) ? $c : $length);
    $ret = ''; for($i=0;$i<$length;$i++){$ret.= chr($simbols[array_rand($simbols)]);}
return $ret;}}
///*/ Функция генерирует GUID из com_create_guid///*/
if(!function_exists('GUID')){function GUID(){return strtoupper(com_create_guid());}}


//------------------------------------------------------------------------------ANALOG-----------------------------------------------------------------------------------------------------------------------------------//  
///*/ Функция аналог str_starts_with из php 8 ///*/
if(!function_exists('str_starts_with')){function str_starts_with(string $haystack, string $needle){
    if(empty($haystack) && empty($needle)){return false;}
return substr($haystack, 0, strlen($needle)) === $needle;}}
///*/ Функция аналог com_create_guid возвращает guid///*/
if(!function_exists('com_create_guid')){function com_create_guid(){
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));}}
                                    
//------------------------------------------------------------------------------DATA-EXCHANGE----------------------------------------------------------------------------------------------------------------------------//  
///*/ Метод эмитации post запроса из php///*/
if(!function_exists('post')){function post(string $url, array $data, array $headers = [], $params = ['opt' => [CURLOPT_RETURNTRANSFER => true, CURLOPT_VERBOSE => true], 'data_json_encode' => false]){
    if(empty($url)){return null;}
    $params['opt'] = (empty($params['opt'])) ? [CURLOPT_RETURNTRANSFER => true, CURLOPT_VERBOSE => true] : $params['opt'];
    $params['opt'][CURLOPT_URL] = $url; 
    $params['opt'][CURLOPT_POST] = true; 
    if(!empty($data))   {$params['opt'][CURLOPT_POSTFIELDS] = ($params['data_json_encode']) ? json_encode($data) : http_build_query($data);}
    if(!empty($headers)){$params['opt'][CURLOPT_HTTPHEADER] = $headers;}
    curl_setopt_array($curl = curl_init(), $params['opt']);
    $ret = curl_exec($curl); curl_close($curl);
return $ret;}}
///*/ Метод эмитации get запроса из php///*/
if (!function_exists('get')) {function get(string $url, array $headers = ['User-Agent: Mozilla/5.0'], $params = ['opt' => [CURLOPT_RETURNTRANSFER => true], 'response_json_decode' => false]): mixed {
    if(empty($url)){return null;}
    $params['opt'] = (empty($params['opt'])) ? [CURLOPT_RETURNTRANSFER => true] : $params['opt'];
    $params['opt'][CURLOPT_URL] = $url;
    if(!empty($headers)){$params['opt'][CURLOPT_HTTPHEADER] = $headers;}
    curl_setopt_array($curl = curl_init(), $params['opt']);
    $response = curl_exec($curl); curl_close($curl);   
return ($response === false) ? null : ($params['response_json_decode'] ? json_decode($response, true) : $response);}}
 
///*/ahilespelid///*/
