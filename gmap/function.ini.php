<?php

$ThaiMonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
$arrmonthnames = array('01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม');

function ThaiDate($InputDate)
{
	global $ThaiMonth;
	if(strlen($InputDate)>7){
		$day=substr($InputDate,8,2);
		$month=substr($InputDate,5,2);
		$month=(int)$month-1;
		$year=substr($InputDate,0,4);
		$year=$year+543;
		$month=$ThaiMonth[$month];
		$thaidatenew= (int)$day." ".$month." ".$year;
	}else{
		$thaidatenew= "";
	}
	return $thaidatenew;
} 
 
function dispArea($t ,$c){
    
    global $db,$query;
    $pre="";
    $ret = "";
    $areatype = $t ; //isset($_GET['t']) ? $_GET['t'] : '';
    $areacode = $c ; //isset($_GET['c']) ? $_GET['c'] : '';

    switch($areatype) {
        case 'zone':
            if(strlen(trim($areacode))==1){
                $areacode= str_pad($areacode,2,"0",STR_PAD_LEFT);
            }
            $query = $db->prepare(" SELECT zonename as n FROM czone WHERE zonecode = :code ; ");
            break;
        case 'province':
            $pre = " จังหวัด";
            if(strlen(trim($areacode))==1){
                $areacode= str_pad($areacode,2,"0",STR_PAD_LEFT);
            }
            $query = $db->prepare("
                    SELECT
                        changwatname as n
                    FROM cchangwat
                    WHERE changwatcode = :code ;
		");
                break;
	case 'ampur':
            $pre = " อำเภอ";
            $query = $db->prepare("
			SELECT ampurname as n
			FROM
				campur
			WHERE ampurcodefull = :code
			;
		");
            break;
	case 'cup':
            $pre = " CUP ";
            $query = $db->prepare("     
                        SELECT hosname as n
			FROM chospital
			WHERE hoscode = :code ;");
            break;
     case 'hospcode':
            $query = $db->prepare("     
                        SELECT hosname as n
			FROM chospital
			WHERE hoscode = :code ;");
            break;
	case 'tumbon':
            $pre = " ตำบล";
            $query = $db->prepare("
			SELECT tambonname as n
			FROM
				ctambon
			WHERE tamboncodefull = :code ;
		");

		break;
	
	case 'village':
            $pre = " หมู่";
		$query = $db->prepare("
			SELECT villagename as n
			FROM
				cvillage
			WHERE villagecodefull = :code ;
		");
		break;
      	  	case 'cmistd':
            $pre = " Service Plan ระดับ ";
		$query = $db->prepare("
			SELECT splevel as n
			FROM
				ccmistd
			WHERE splevel = :code  ;
		");
		break;

	case 'nation':
         $pre = " สัญชาติ";
		$query = $db->prepare("
			SELECT nationname as n
			FROM
				cnation
			WHERE nationcode = :code  ;
		");
		break;
	case 'nation_group':
         $pre = " สัญชาติ";
		$query = $db->prepare("
			SELECT nationname_thai as n
			FROM
				cnation_aec
			WHERE nationgroup_aec = :code  ;
		");
		break;
	case 'labor_group':
         $pre = " ต่างด้าวประเภท";
		$query = $db->prepare("
			SELECT group_name as n
			FROM
				clabor_group
			WHERE labor_group = :code  ;
		");
		break;

    }
    try {
        $query->bindValue(':code',$areacode, PDO::PARAM_STR);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $data = "";
        foreach ($rows as $value){
            $ret = $pre.$value['n'];

        }
    }catch(PDOException $e){
	echo $e->getMessage();
    }    
    return $ret;
} 
function ReturnUrl($request_uri) {
    $arr = array();
    $uri = $request_uri;
    $arr = explode("/", $uri);
    $url = $arr[0]."/".$arr[1];	
    return $url;
}

function lnVarPrepForStore(){
    $resarray = array();
    foreach (func_get_args() as $ourvar) {

        // Prepare var
        if (!get_magic_quotes_runtime()) {
            $ourvar = addslashes($ourvar);
        }

        // Add to array
        array_push($resarray, $ourvar);
    }

    // Return vars
    if (func_num_args() == 1) {
        return $resarray[0];
    } else {
        return $resarray;
    }
}

?>