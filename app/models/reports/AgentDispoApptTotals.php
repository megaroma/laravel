<?php
namespace Reports;
class AgentDispoApptTotals {

public static function get_list($filters,$order,$sort,$page) {
$per_page = \Config::get('view.per_page');


$start_date = '01/01/2014';
$end_date = '08/31/2014';
$customer_id = 1;
$user_id = '3';//3;
$chkUsersWithPhone = '';

if($sort != '') {
	$order_sql = "ORDER BY ".$sort." ".$order;
} else {
	$order_sql = "ORDER BY u.name";
}

$limit_sql = "LIMIT ".(($page-1)*$per_page)." , ".($page*$per_page);

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
AND u.id like ? 
AND (cc.timestamp BETWEEN ? AND ? ) 
GROUP BY u.id)' ,array($customer_id,$user_id,$start_date,$end_date));

\DB::statement('CREATE INDEX user_id ON campaign_calls_temp (user_id)');

$results = \DB::select(
'SELECT 
u.id as `id`,
c.name, 
u.name as AgentName, 
CONCAT(DATE_FORMAT(? ,\'%m/%d/%y\'),\' - \',DATE_FORMAT(  ? ,\'%m/%d/%y\')) AS `call_perod`, 
total_dispositions, 
appt_set 
FROM customers c 
INNER JOIN users u ON (c.id = u.customer_id) ' . $chkUsersWithPhone . ' 
LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id) 
WHERE 
c.id = ?
AND u.id like ? 
'.$order_sql.'
'.$limit_sql

,array($start_date,$end_date,$customer_id,$user_id)
	);

$res_total = \DB::select(
'SELECT 
count(*) as `total`
FROM customers c 
INNER JOIN users u ON (c.id = u.customer_id) ' . $chkUsersWithPhone . ' 
LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id) 
WHERE 
c.id = ?
AND u.id like ? 
'
,array($customer_id,$user_id)
	);


return array(
	'list' => json_decode(json_encode($results), true),
	'total' => $res_total[0]->total
	);

}



}