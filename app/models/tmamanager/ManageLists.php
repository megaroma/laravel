<?php
namespace Tmamanager;
class ManageLists extends \Campaign {

public static function get_list($filters,$order,$sort,$page) {
$per_page = \Config::get('view.per_page');
$filters_sql = \Crud::get_filters_sql($filters);

if($sort != '') {
	$order_sql = "ORDER BY ".$sort." ".$order;
} else {
	$order_sql = "ORDER BY agentname, c.priority,c.id ASC";
}

$limit_sql = "LIMIT ".(($page-1)*$per_page)." , ".($per_page);

$sql = "
SELECT 
c.id,
0 AS ttl_list, 
0 AS ttl_complete, 
0 AS ttl_readytocall, 
0 AS ttl_nevercalled, 
c.name, 
u.name AS `agentname`, 
c.assigned_user_id, 
c.priority,
DATE_FORMAT(c.created_at,'%m-%d-%Y') as created_at, 
DATE_FORMAT(
	NOW()
,'%m-%d-%Y')
	 AS last_disposition, 
i.name AS image_name,
i.mime, 
i.size 
FROM campaigns c 
     LEFT OUTER JOIN images i ON c.direct_mail_piece_image_id = i.id 
	 LEFT OUTER JOIN users u ON c.assigned_user_id = u.id  
WHERE 

".$filters_sql." ".$order_sql." ".$limit_sql;


$results = \DB::select($sql,array());


$res_total = \DB::select(
'SELECT 
count(*) as `total`
FROM campaigns c where '.$filters_sql,array());	

return array(
	'list' => json_decode(json_encode($results), true),
	'total' => $res_total[0]->total
	);

}


}



/*
SELECT 
c.id,
(SELECT COUNT(*) FROM campaign_prospects WHERE campaign_id = c.id) AS ttl_list, 
(SELECT COUNT(*) FROM campaign_prospects WHERE campaign_id = c.id AND finished = TRUE) AS ttl_complete, 
(SELECT COUNT(*) FROM campaign_prospects cp 
                      LEFT JOIN campaigns c1 ON (c1.id = cp.campaign_id) 
                      LEFT OUTER JOIN master_callback_schedule mc ON  
					                       (mc.campaign_prospect_telephone = cp.telephone 
										      AND mc.customer_id = c1.customer_id ) 
                  WHERE campaign_id = c.id 
				        AND finished = FALSE 
						AND ((cp.next_call_scheduled IS NULL 
						AND mc.earliest_next_callback_allowed IS NULL)  
						OR (cp.next_call_scheduled < NOW() 
						OR mc.earliest_next_callback_allowed < NOW()))
) AS ttl_readytocall, 
(SELECT COUNT(*) FROM campaign_prospects cp 
                 LEFT JOIN campaigns c1 ON (c1.id = cp.campaign_id) 
				 LEFT OUTER JOIN master_callback_schedule mc ON (mc.campaign_prospect_telephone = cp.telephone 
				                                             AND mc.customer_id = c1.customer_id ) 
				 WHERE campaign_id = c.id 
				       AND finished = FALSE 
					   AND cp.next_call_scheduled IS NULL 
					   AND mc.earliest_next_callback_allowed IS NULL
) AS ttl_nevercalled, 
(SELECT MAX(cc.timestamp) FROM campaign_prospects cp 
                          LEFT JOIN campaign_calls cc ON (cp.id = cc.campaign_prospect_id)  
						  WHERE cp.campaign_id = c.id
) AS last_disposition, 
c.assigned_user_id, 
c.name, 
u.name AS agentname, 
c.priority,
c.created_at, 
i.name AS image_name,
i.mime, 
i.size 
FROM campaigns c 
     LEFT OUTER JOIN images i ON c.direct_mail_piece_image_id = i.id 
	 LEFT OUTER JOIN users u ON c.assigned_user_id = u.id  
WHERE 
(c.customer_id =  1 -- :customer_id 
AND c.priority = 99 -- = 99 Archive, =! 99 Active
-- AND c.assigned_user_id = :assigned_user_id
) 
ORDER BY agentname, c.priority,c.id ASC


*/