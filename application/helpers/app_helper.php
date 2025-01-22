<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function is_logged_in()
{
	$CI =& get_instance();
	$ss = $CI->session->userdata('logged_in');
	if($ss != '')
	{
		return TRUE;
	}
	return FALSE;
}

if (!function_exists('get_csrf_token')){
	function get_csrf_token() {
		$ci = get_instance();
		if (!$ci->session->csrf_token){
			$ci->session->csrf_token = hash('sha1',time());
		}
		return $ci->session->csrf_token;

	}
}

if (!function_exists('get_csrf_name')){
	function get_csrf_name() {
		return "token";
	}
}

function safe($str)
{
    return strip_tags(trim($str));
}

function read_json($path)
{
    $string = file_get_contents($path);
    $obj = json_decode($string);
    return $obj;
}

function generate_crud($string, $path)
{
    $create = fopen($path, "w") or die("Unable to open file!");
    fwrite($create, $string);
    fclose($create);
    return $path;
}

function generate_crud2($string, $path)
{
    $create = fopen($path, "w");
    fwrite($create, $string);
    fclose($create);
    return $path;
}

function delete_recursive($path)
{
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? delete_recursive($file) : unlink($file);
    }
    rmdir($path);
}

function label($str)
{
    $label = str_replace('_', ' ', $str);
    $label = ucwords($label);
    return $label;
}

// if (!function_exists('cek_csrf')){
// function cek_csrf(){
// 	$ci = get_instance();
// 	if ($ci->input->post('token')!= $ci->session->csrf_token){
// 		$ci->session->unset_userdata('csrf_token');
// 		echo "gagal";
// 		return false;
// 	}
// }
// }



function from_session($key)
{
	$CI =& get_instance();
	$ss = $CI->session->userdata($key);
	return $ss;
}
function ajaxLink($url,$div,$name,$tamb='')
{
	return "<a href='javascript:void(0)' onclick='show(\"".$url."\",\"".$div."\")' ".$tamb.">".$name."</a>";
}
function ajaxButton($url,$div,$name,$extra='')
{
	return "<button ".$extra." onclick='show(\"".$url."\",\"".$div."\")'>".$name."</button>";
}
function popupButton($url,$title)
{
	return "<a class='button' href='javascript:void(0)' onclick='window.open(".site_url()."/".$url.", \"_blank\")' ><span>".$title."</span></a>";
}
function popupLink($url,$title)
{
	return "<a href='javascript:void(0)' onclick='window.open(\"".site_url()."/".$url."\", \"_blank\")' >".$title."</a>";
}
function is_valid_date($a)
{
	$d=substr($a,8,2); //tanggal
	$m=substr($a,5,2); //bulan
	$y=substr($a,0,4); //tahun
	return checkdate($m,$d,$y);
} 
function order_array ($array, $key) 
{
	$tmp = array();
	foreach($array as $akey => $array2) {
		$tmp[$akey] = $array2[$key];
	}
	sort($tmp , SORT_NUMERIC ); //Change this if you have an associative array
	$tmp2 = array();
	$tmp_size = count($tmp);
	foreach($tmp as $key => $value) {
		$tmp2[$key] = $array[$key];
	}
	return $tmp2;
}
function remove_empty_values($array, $remove_null_number = true)
{
	$new_array = array();

	$null_exceptions = array();

	foreach ($array as $key => $value)
	{
		$value = trim($value);

		if($remove_null_number)
		{
			$null_exceptions[] = '0';
		}

		if(!in_array($value, $null_exceptions) && $value != "")
		{
			$new_array[] = $value;
		}
	}
	return $new_array;
}
function error_string($text='-error-')
{
	return "<span class='error'>".$text."</span>";
}
function no_data_string($text='Data masih kosong.')
{
	return "<br /><p align='center' style='color:#A8A8A8'>$text</p><br />";
}
function sukses($text='Sukses')
{
	return "<br /><p align='center' style='color:#6773BA'>$text</p><br />";
}
function form_nominal($name,$id,$width,$value='')
{
	return '<input type="text" style="width:'.$width.'" name="'.$name.'" id="'.$id.'" onkeyup="formatNumber(this);" onchange="formatNumber(this);" value="'.$value.'" />';
}
function setExcelHeader($excel_file_name)//this function used to set the header variable
{		
	header("Content-type: application/octet-stream");//A MIME attachment with the content type "application/octet-stream" is a binary file.
	//Typically, it will be an application or a document that must be opened in an application, such as a spreadsheet or word processor. 
	header("Content-Disposition: attachment; filename=$excel_file_name");//with this extension of file name you tell what kind of file it is.
	header("Pragma: no-cache");//Prevent Caching
	header("Expires: 0");//Expires and 0 mean that the browser will not cache the page on your hard drive
}