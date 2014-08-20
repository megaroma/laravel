<?php
namespace Reports;
class AgentDispoApptTotals {

public static function get_list($filters,$order,$sort,$page) {
$per_page = \Config::get('view.per_page');

$start_date = '01/01/2013';
$end_date = date('m/d/Y');
$chkUsersWithPhone = '';
$user_id_sql = "";

foreach ($filters as $filter) {
	$field = key($filter);
	if($field == 'timestamp') {
		if($filter[$field]['data'] != '')
			$start_date = $filter[$field]['data'];
		if($filter[$field]['data2'] != '')
			$end_date = $filter[$field]['data2'];		
	} elseif($field ==  'UsersWithPhone') {
		$chkUsersWithPhone = 'INNER JOIN devices dev ON (dev.id = u.device_id)';
	} elseif($field ==  'user_id') {
		if($filter[$field]['data'] != '') {
			$user_id_sql = \Crud::get_selector_code('u.id',$filter[$field]['selector'],$filter[$field]['data']);
			$user_id_sql = ' and '.$user_id_sql.' ';
		}
	} elseif($field ==  'customer_id') {
		$customer_id = $filter[$field]['data'];
	}

}






if($sort != '') {
	$order_sql = "ORDER BY ".$sort." ".$order;
} else {
	$order_sql = "ORDER BY u.name";
}

$limit_sql = "LIMIT ".(($page-1)*$per_page)." , ".($per_page);

\DB::statement('DROP TEMPORARY TABLE IF EXISTS campaign_calls_temp');
\DB::statement(
'CREATE TEMPORARY TABLE IF NOT EXISTS campaign_calls_temp AS 
(SELECT 
u.id AS user_id, 
u.name AS user_name, 
SUM(IF(cc.id IS NOT NULL,1,0)) AS total_dispositions, 
SUM(IF(d.standard_disposition_id IS NOT NULL AND d.standard_disposition_id = 31,1,0)) AS appt_set 
FROM customers c 
INNER JOIN users u ON (c.id = u.customer_id) 
LEFT OUTER JOIN campaign_calls cc ON (cc.user_id = u.id) 
INNER JOIN dispositions d ON (cc.disposition_id = d.id) 
WHERE c.id = ? 
 '.$user_id_sql.' 
 AND (cc.timestamp BETWEEN STR_TO_DATE( ?,\'%m/%d/%Y\') AND STR_TO_DATE(  ? ,\'%m/%d/%Y\') ) 
GROUP BY u.id)' ,array($customer_id,$start_date,$end_date));

\DB::statement('CREATE INDEX user_id ON campaign_calls_temp (user_id)');

//CONCAT(DATE_FORMAT( ?,\'%m/%d/%y\'),\' - \',DATE_FORMAT(  ? ,\'%m/%d/%y\')) AS `call_perod`, 

$results = \DB::select(
'SELECT 
u.id as `id`,
c.name, 
u.name as AgentName, 
CONCAT( ?,\' - \', ? ) AS `call_perod`, 
total_dispositions, 
appt_set 
FROM customers c 
INNER JOIN users u ON (c.id = u.customer_id) ' . $chkUsersWithPhone . ' 
LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id) 
WHERE 
c.id = ?
 '.$user_id_sql.' 
 '.$order_sql.'
 '.$limit_sql

,array($start_date,$end_date,$customer_id)
	);

$res_total = \DB::select(
'SELECT 
count(*) as `total`
FROM customers c 
INNER JOIN users u ON (c.id = u.customer_id) ' . $chkUsersWithPhone . ' 
LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id) 
WHERE 
c.id = ?
 '.$user_id_sql.' '
,array($customer_id)
	);


return array(
	'list' => json_decode(json_encode($results), true),
	'total' => $res_total[0]->total
	);

}



}