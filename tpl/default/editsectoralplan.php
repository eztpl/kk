<?php
!defined('kele_start') && die('NOTFINDE');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['KELE']['charset_kele']?>" />
<link href="<?php echo http_dir?>CGI/css/admincss.css" rel="stylesheet" type="text/css" />
<title><?php echo $GLOBALS['KELE']['title']?></title>

</head>
<body>
<div class="menu"> 
<ul>
<li class="onck"><!--<a href="<?php echo http_dir?>?model=append&contro=function&view=<?php echo $this->view?>">AddForm</a>-->&nbsp;<a href="<?php echo http_dir?>?model=show&contro=function&view=<?php echo $this->view?>">ShowForm</a></li>
</ul>
</div>
<?php
	$pid=keledata::httpval("pid")?keledata::httpval("pid"):$GLOBALS['DATA']['sectoralplan']['projectplanid'];
	if(keledata::checkdata($pid,"int"))$pname=keledatabase::getthisone(array("project_plan","project_management"),
			array("project_plan.id=".$pid,"project_plan.projectid=project_management.id"),
			array("project_management.name","project_management.id","project_plan.classify"));
	$memu=kelefunction::memu($this->view);
?>
	<form name="<?php echo $memu['memu']['value']?>" action="<?php echo http_dir?>?model=<?php echo $this->model?>&contro=function&view=<?php echo $this->view?>" enctype="multipart/form-data" method="post">
    <table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C9C9C9" style="margin:10px;">
      	<?php 
      	foreach ($memu['element'] as $memus){
      	foreach($memus as $k => $val){
      			if($val['field']=="projectid"&&$pname){$val['defaults']=$pname['name'];$GLOBALS['DATA'][$val['classify']][$val['field']]=$pname['id'];}
      			else if($val['field']=="projectplanid"&&$pid)$GLOBALS['DATA'][$val['classify']][$val['field']]=$pid;
      			else if($val['field']=="classify"&&$pname){
      				$defaults=explode("|", $val['defaults']);
      				foreach ($defaults as $df){
      					$dfarr=explode(":", $df);
      					if($pname['classify']==$dfarr[1])$val['defaults']=$dfarr[0];
      				}
      				$GLOBALS['DATA'][$val['classify']][$val['field']]=$pname['classify'];
      			}
      			if($val['type']!="hidden")echo"<tr><td>".$val['name']."</td><td>&nbsp;&nbsp;".element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['DATA'][$val['classify']][$val['field']],$val['size'])."</td></tr>";
      			else echo element($val['type'],$val['classify']."[".$val['field']."]",$val['defaults'],$GLOBALS['DATA'][$val['classify']][$val['field']],$val['size']);
      	}?>
      	<input type="hidden" name="<?php echo $val['classify']?>[id]" value="<?php echo $GLOBALS['DATA'][$val['classify']]['id']?>"/>
      	<?php }?>
      </table>
		<div align="center">
		<input type="hidden" name="<?php echo $this->model?>" value="true" />
	      <input type="submit" name="Submit" value="Submit" />
        </div>
  </form>
</body>
</html>
