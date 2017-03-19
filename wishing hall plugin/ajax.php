<?php
/*
	wishing_hall ajax By bikai[RS Team] 2013-02-10
*/
//$firstvister = DB::fetch_first("SELECT m.username,q.todaysay,q.godsay FROM ".DB::table('dsu_paulsign_wish')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid and time >= {$tdtime} ORDER BY q.time");
  
//header("Content-Type: application/xml");
header("Content-Type:text/xml;charset=utf8");
header("Cache-Control:no-cache");   

// if($_GET['action'] == 'checkusername') {  
$conn=mysql_connect("localhost","root",""); 
     if(!$conn){   
         echo "连接错误|00";   
     }//else{echo "连接数据库成功|00"; }   
	 
     mysql_select_db("ruisi");   
     mysql_query("set names utf8");    
 //查询
     $res = mysql_query("SELECT * FROM pre_dsu_paulsign_wish");  

//	 if($res){die("操作失败").mysql_error();} 
 	$result='';
 	while($row=mysql_fetch_row($res)){
		foreach($row as $key=>$val){$result.="$val";}			
	}
  
//  if(mysql_num_rows($res)) {   
//           $result="";   
//       }else{   
//          $result='suc|ceed';   
//   }
  
echo $result."|aa";   
//mysql_free_result($res);
mysql_close($conn);
//}   
?>  