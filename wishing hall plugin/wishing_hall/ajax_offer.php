<?php
/*
	wishing_hall ajax with redis By bikai[RS Team] 2013-02-15
*/
require_once('rsmysqlDB.php');
header("Content-Type:text/xml;charset=utf-8");
header("Cache-Control:no-cache");

if($_SERVER['REQUEST_METHOD']=='GET'){exit("Access Denied!");}

// if($_GET['action'] == 'checkusername') {
$redis = new redis();
$redis->connect('127.0.0.1',6379);

//read redis
$wishing_items=(int)$redis->get('items_offer');
	if($wishing_items){
		$result='';
echo '<?xml version="1.0" encoding="utf-8"?>
<root_redis>
<item>'.$wishing_items.'</item>
';
		for($i=1;$i<=$wishing_items;$i++){
				$wishes_buf=$redis->lgetrange("wishes_offer".$i,0,-1);
$result.="<wishing>
	<username>".$wishes_buf[0]."</username>
	<uid>".$wishes_buf[1]."</uid>
	<time>".$wishes_buf[2]."</time>
	<qdxq>".$wishes_buf[3]."</qdxq>
	<todaysay>".$wishes_buf[4]."</todaysay>
	<godsay>".$wishes_buf[5]."</godsay>
</wishing>
";
			}
	echo $result."</root_redis>";
	 		
	}else{//use mysql
	$result=''; 
	$conn=mysql_connect("localhost",$username,$password);
     if(!$conn){   
         die('Could not connect: '.mysql_error());
     }//else{echo "连接数据库成功!"; }   
	 
     mysql_select_db($dbname,$conn);   
     mysql_query("set names utf8");    
 //查询
     $res = mysql_query("SELECT q.uid,q.time,q.qdxq,q.todaysay,q.godsay,m.username FROM wishing_hall_wish_offer q,common_member m where q.uid=m.uid order by q.time desc limit 0,10");  
$redis->set('items_offer',mysql_num_rows($res));
echo '<?xml version="1.0" encoding="utf-8"?>
<root>
<item>'.mysql_num_rows($res).'</item>
';
	
	$redis->setTimeout('items_offer', 3);	
	$index=1;	
//	print_r(mysql_fetch_array($res));
 	while($row=mysql_fetch_array($res)){
//		foreach($row as $key=>$val){$result.="$val";}
		if($row['qdxq']=="kx_offer"){$row['qdxq']="虔诚的想要听取神的教诲，并说";
		}elseif($row['qdxq']=="ng_offer"){$row['qdxq']="给神磕了个大大的响头，并说";
		}elseif($row['qdxq']=="ym_offer"){$row['qdxq']="给神上了一炷香，并说";
		}elseif($row['qdxq']=="wl_offer"){$row['qdxq']="给神献上鲜花，并说";
		}elseif($row['qdxq']=="nu_offer"){$row['qdxq']="给神敬上一个摩提，并说";
		}elseif($row['qdxq']=="ch_offer"){$row['qdxq']="给神敬上一杯酒，并说";
		}elseif($row['qdxq']=="yl_offer"){$row['qdxq']="给神献上巧克力，并说";
		}elseif($row['qdxq']=="shuai_offer"){$row['qdxq']="要给考神修庙建祠堂，并说";
		}
			
$result.="<wishing>
	<username>".$row['username']."</username>
	<uid>".$row['uid']."</uid>
	<time>".gmdate('Y-m-d H:i',$row["time"]+ 3600 * 8)."</time>
	<qdxq>".$row['qdxq']."</qdxq>
	<todaysay>".$row['todaysay']."</todaysay>
	<godsay>".$row['godsay']."</godsay>
</wishing>
";	
//将许愿缓存到redis中
	$redis->delete("wishes_offer".$index);
	$redis->rpush("wishes_offer".$index,$row['username']);
	$redis->rpush("wishes_offer".$index,$row['uid']);	
	$redis->rpush("wishes_offer".$index,gmdate('Y-m-d H:i',$row["time"]+ 3600 * 8));	
	$redis->rpush("wishes_offer".$index,$row['qdxq']);	
	$redis->rpush("wishes_offer".$index,$row['todaysay']);	
	$redis->rpush("wishes_offer".$index,$row['godsay']);	
	$index++;	
	}
echo $result."</root>"; 
	//mysql_free_result($res);
	mysql_close($conn);
}

$redis->close();
?>  