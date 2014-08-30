-- TMA Soft Phone Stats


CALL make_intervals(:startdt,:enddt,1,'DAY'); 

SET @rank=0;

SELECT 
@rank:=@rank+1 AS rank, 
agents.*,x.`Date`, 
IFNULL(x.`ttlcalls`,0) AS ttlcalls, 
IFNULL(x.ttlmin,0) AS ttlmin, 
IFNULL(x.ACD_Min,0) AS ACD_Min, 
IFNULL(x.ttlringmin,0) AS ttlringmin, 
IFNULL(x.ARD_Min,0) AS ARD_Min, 
IFNULL(ttldispocalls,0) AS ttldispocalls, 
IFNULL(disp1,0) AS disp1, 
IFNULL(disp3,0) AS disp3, 
IFNULL(disp5,0) AS disp5, 
IFNULL(disp7,0) AS disp7, 
IFNULL(disp9,0) AS disp9, 
IFNULL(disp11,0) AS disp11, 
IFNULL(disp13,0) AS disp13, 
IFNULL(disp15,0) AS disp15, 
IFNULL(disp17,0) AS disp17, 
IFNULL(disp19,0) AS disp19, 
IFNULL(disp21,0) AS disp21, 
IFNULL(disp23,0) AS disp23, 
IFNULL(disp25,0) AS disp25, 
IFNULL(disp27,0) AS disp27, 
IFNULL(disp29,0) AS disp29, 
IFNULL(disp31,0) AS disp31, 
IFNULL(disp33,0) AS disp33, 
IFNULL(disp35,0) AS disp35 
FROM 
(SELECT c.name AS Cust_Name, 
		u.customer_id, 
		u.id AS user_id, 
		d.sipusername, 
		u.name AS Agent_Name FROM customers c 
		INNER JOIN users u ON (c.id = u.customer_id) 
		INNER JOIN devices d ON (d.id = u.device_id) 
		WHERE c.id = :cust_id AND u.id = " + Convert.ToInt32(agentid) + ") `agents` 
LEFT OUTER JOIN (SELECT c.name AS Cust_Name, 
						u.customer_id, 
						u.id AS user_id, 
						d.sipusername, 
						u.name AS Agent_Name, 
						DATE(t.interval_start) AS `Date`, 
						COUNT(*) - IF (SUM(billsec) IS NULL, 1, 0) AS `ttlcalls`, 
						SUM(billsec)/60 AS ttlmin,
						SUM(billsec)/(COUNT(*)*60) AS ACD_Min, 
						(SUM(duration) - SUM(billsec))/60 AS ttlringmin, 
						(SUM(duration) - SUM(billsec))/(COUNT(*)*60) AS ARD_Min 
						FROM customers c 
						INNER JOIN users u ON (c.id = u.customer_id) 
						INNER JOIN devices d ON (d.id = u.device_id) 
						CROSS JOIN time_intervals  t 
						LEFT OUTER JOIN cdr cd USE INDEX (start_stamp) ON 
												(cd.user_name = d.sipusername 
													AND cd.domain_name = c.SipDomain 
													AND cd.start_stamp BETWEEN :startdt AND :enddt 
													AND DATE(cd.start_stamp) = DATE(t.interval_start)) 
						WHERE c.id = :cust_id AND u.id = " + Convert.ToInt32(agentid) + " 
						GROUP BY u.customer_id,d.sipusername,Date) x ON x.sipusername = agents.sipusername 
	LEFT OUTER JOIN (SELECT customer_id, 
							user_id, 
							sipusername, 
							`Date`, 
							dispid,
							CAST(MAX(IF(dispid=1,ttl,'')) AS CHAR) AS disp1, 
							CAST(MAX(IF(dispid=3,ttl,'')) AS CHAR) AS disp3,
							CAST(MAX(IF(dispid=5,ttl,'')) AS CHAR) AS disp5, 
							CAST(MAX(IF(dispid=7,ttl,'')) AS CHAR) AS disp7,
							CAST(MAX(IF(dispid=9,ttl,'')) AS CHAR) AS disp9, 
							CAST(MAX(IF(dispid=11,ttl,'')) AS CHAR) AS disp11,
							CAST(MAX(IF(dispid=13,ttl,'')) AS CHAR) AS disp13,
							CAST(MAX(IF(dispid=15,ttl,'')) AS CHAR) AS disp15,
							CAST(MAX(IF(dispid=17,ttl,'')) AS CHAR) AS disp17,
							CAST(MAX(IF(dispid=19,ttl,'')) AS CHAR) AS disp19,
							CAST(MAX(IF(dispid=21,ttl,'')) AS CHAR) AS disp21,
							CAST(MAX(IF(dispid=23,ttl,'')) AS CHAR) AS disp23,
							CAST(MAX(IF(dispid=25,ttl,'')) AS CHAR) AS disp25, 
							CAST(MAX(IF(dispid=27,ttl,'')) AS CHAR) AS disp27,
							CAST(MAX(IF(dispid=29,ttl,'')) AS CHAR) AS disp29,
							CAST(MAX(IF(dispid=31,ttl,'')) AS CHAR) AS disp31,
							CAST(MAX(IF(dispid=33,ttl,'')) AS CHAR) AS disp33,
							CAST(MAX(IF(dispid=35,ttl,'')) AS CHAR) AS disp35,
							SUM(ttl) AS ttldispocalls 
							FROM (SELECT u.customer_id, u.id AS user_id, 
										d.sipusername, 
										DATE(cc.call_start_stamp) AS `Date`, 
										dispositions.standard_disposition_id AS dispid,
										dispositions.name AS disponame,
										COUNT(*) AS ttl 
								FROM dispositions 
								INNER JOIN customers c ON c.id = dispositions.customer_id 
								INNER JOIN users u ON c.id = u.customer_id 
								INNER JOIN devices d ON (d.id = u.device_id) 
								INNER JOIN campaign_calls cc ON (cc.user_id = u.id 
																AND cc.disposition_id = dispositions.id) 
								WHERE (standard_disposition_id != '' 
									AND standard_disposition_id IS NOT NULL ) 
								AND cc.call_start_stamp BETWEEN :startdt AND :enddt 
								AND c.id = :cust_id 
								AND u.id = '" + agentid + "' 
								GROUP BY u.customer_id,d.sipusername,`Date`, dispositions.standard_disposition_id) xx 
								GROUP BY user_id,`Date` ) dispos 
	ON agents.customer_id = dispos.customer_id 
	AND agents.sipusername = dispos.sipusername 
	AND x.Date = dispos.Date 
ORDER BY customer_id,sipusername,`Date` ASC; 









----------------------------------------------------
--TMA Soft Phone CDR


SET @rank=0;

SELECT 
@rank:=@rank+1 AS rank, 
c.name AS Cust_Name, 
u.customer_id, 
d.sipusername, 
u.name AS Agent_Name, 
cd.*, 
disp.name AS disposition, 
cp.name AS campaign_prospect_name 
FROM customers c 
INNER JOIN users u ON (c.id = u.customer_id) 
INNER JOIN devices d ON (d.id = u.device_id) 
INNER JOIN cdr cd ON (cd.user_name = d.sipusername AND cd.domain_name = c.sipdomain) 
LEFT OUTER JOIN campaign_calls cc ON (cc.uuid = cd.uuid) 
LEFT OUTER JOIN campaign_prospects cp ON (cp.id = cc.campaign_prospect_id) 
LEFT OUTER JOIN dispositions disp ON (disp.id = cc.disposition_id AND c.id = disp.customer_id) 
WHERE cd.start_stamp BETWEEN '" + strFrom + "' AND '" + strTo + "' 
AND c.id = '" + Convert.ToInt32(sessCustomer_id) + "' 
AND u.id = '" + Convert.ToInt32(intUID) + "' 
AND (cd.destination_number LIKE '" + strTel + "' ) 
AND (cp.name LIKE '" + strProspectName + "' )



--------------------------------------------------------
 ---AgentDispoApptStats        


CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); 
CALL drop_campaign_calls_temp; 
CREATE TEMPORARY TABLE campaign_calls_temp AS (
	SELECT 
	cc.id AS call_id, 
	cc.timestamp, 
	cc.user_id,
	d.standard_disposition_id 
	FROM campaign_calls cc 
	INNER JOIN dispositions d ON (cc.disposition_id = d.id) 
	INNER JOIN users u ON (cc.user_id = u.id) 
	WHERE u.customer_id = '" + custid + "' 
	AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); 

CREATE INDEX user_id ON campaign_calls_temp (user_id); 

SET @rank=0;

SELECT
@rank:=@rank+1 AS rank, 
c.name AS customer_name, 
u.name AS user_name, 
DATE(t.interval_start) AS `call_date`, 
SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, 
SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set 
FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) 
INNER JOIN time_intervals t " + chkUsersWithPhone + " 
LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) 
WHERE c.id = '" + custid + "' AND u.id = '" + intUID + "' 
GROUP BY user_name,call_date ORDER BY user_name,call_date;";






        




       {
            chkUsersWithPhone = "INNER JOIN devices dev ON (dev.id = u.device_id)";
        }
        if (tmaExists == true)
        {
            intUID = Convert.ToInt32(Agentid);
            //sqlQry = "CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); CALL drop_campaign_calls_temp; CREATE TEMPORARY TABLE campaign_calls_temp AS (SELECT cc.id AS call_id, cc.timestamp, cc.user_id,d.standard_disposition_id FROM campaign_calls cc INNER JOIN dispositions d ON (cc.disposition_id = d.id) INNER JOIN users u ON (cc.user_id = u.id) WHERE u.customer_id = '" + custid + "' AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); CREATE INDEX user_id ON campaign_calls_temp (user_id); SELECT c.name AS customer_name, u.name AS user_name, DATE(t.interval_start) AS `call_date`, SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) INNER JOIN time_intervals t " + chkUsersWithPhone + " LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) WHERE c.id = '" + custid + "' AND u.id = '" + intUID + "' GROUP BY user_name,call_date ORDER BY user_name,call_date;";
            sqlQry = "CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); CALL drop_campaign_calls_temp; CREATE TEMPORARY TABLE campaign_calls_temp AS (SELECT cc.id AS call_id, cc.timestamp, cc.user_id,d.standard_disposition_id FROM campaign_calls cc INNER JOIN dispositions d ON (cc.disposition_id = d.id) INNER JOIN users u ON (cc.user_id = u.id) WHERE u.customer_id = '" + custid + "' AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); CREATE INDEX user_id ON campaign_calls_temp (user_id); SET @rank=0;SELECT @rank:=@rank+1 AS rank, c.name AS customer_name, u.name AS user_name, DATE(t.interval_start) AS `call_date`, SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) INNER JOIN time_intervals t " + chkUsersWithPhone + " LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) WHERE c.id = '" + custid + "' AND u.id = '" + intUID + "' GROUP BY user_name,call_date ORDER BY user_name,call_date;";
        }
        else
        {
            if (ddlUsersSelIndex == 0)
            {
                //sqlQry = "CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); CALL drop_campaign_calls_temp; CREATE TEMPORARY TABLE campaign_calls_temp AS (SELECT cc.id AS call_id, cc.timestamp, cc.user_id,d.standard_disposition_id FROM campaign_calls cc INNER JOIN dispositions d ON (cc.disposition_id = d.id) INNER JOIN users u ON (cc.user_id = u.id) WHERE u.customer_id = '" + custid + "' AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); CREATE INDEX user_id ON campaign_calls_temp (user_id); SELECT c.name AS customer_name, u.name AS user_name, DATE(t.interval_start) AS `call_date`, SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) INNER JOIN time_intervals t " + chkUsersWithPhone + " LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) WHERE c.id = '" + custid + "' AND u.id LIKE '%' GROUP BY user_name,call_date ORDER BY user_name,call_date;";
                sqlQry = "CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); CALL drop_campaign_calls_temp; CREATE TEMPORARY TABLE campaign_calls_temp AS (SELECT cc.id AS call_id, cc.timestamp, cc.user_id,d.standard_disposition_id FROM campaign_calls cc INNER JOIN dispositions d ON (cc.disposition_id = d.id) INNER JOIN users u ON (cc.user_id = u.id) WHERE u.customer_id = '" + custid + "' AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); CREATE INDEX user_id ON campaign_calls_temp (user_id); SET @rank=0;SELECT @rank:=@rank+1 AS rank, c.name AS customer_name, u.name AS user_name, DATE(t.interval_start) AS `call_date`, SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) INNER JOIN time_intervals t " + chkUsersWithPhone + " LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) WHERE c.id = '" + custid + "' AND u.id LIKE '%' GROUP BY user_name,call_date ORDER BY user_name,call_date;";
            }
            else
            {
                intUID = Convert.ToInt32(Agentid);
                //sqlQry = "CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); CALL drop_campaign_calls_temp; CREATE TEMPORARY TABLE campaign_calls_temp AS (SELECT cc.id AS call_id, cc.timestamp, cc.user_id,d.standard_disposition_id FROM campaign_calls cc INNER JOIN dispositions d ON (cc.disposition_id = d.id) INNER JOIN users u ON (cc.user_id = u.id) WHERE u.customer_id = '" + custid + "' AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); CREATE INDEX user_id ON campaign_calls_temp (user_id); SELECT c.name AS customer_name, u.name AS user_name, DATE(t.interval_start) AS `call_date`, SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) INNER JOIN time_intervals t " + chkUsersWithPhone + " LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) WHERE c.id = '" + custid + "' AND u.id = '" + intUID + "' GROUP BY user_name,call_date ORDER BY user_name,call_date;";
                sqlQry = "CALL make_intervals('" + strfrom + "','" + strto + "',1,'DAY'); CALL drop_campaign_calls_temp; CREATE TEMPORARY TABLE campaign_calls_temp AS (SELECT cc.id AS call_id, cc.timestamp, cc.user_id,d.standard_disposition_id FROM campaign_calls cc INNER JOIN dispositions d ON (cc.disposition_id = d.id) INNER JOIN users u ON (cc.user_id = u.id) WHERE u.customer_id = '" + custid + "' AND cc.timestamp BETWEEN '" + strfrom + "' AND '" + strto + "'); CREATE INDEX user_id ON campaign_calls_temp (user_id); SET @rank=0;SELECT @rank:=@rank+1 AS rank, c.name AS customer_name, u.name AS user_name, DATE(t.interval_start) AS `call_date`, SUM(IF(cc.call_id IS NOT NULL,1,0)) AS total_dispositions, SUM(IF(cc.standard_disposition_id IS NOT NULL AND cc.standard_disposition_id = 31,1,0)) AS appt_set FROM (customers c INNER JOIN users u ON (c.id = u.customer_id) ) INNER JOIN time_intervals t " + chkUsersWithPhone + " LEFT OUTER JOIN campaign_calls_temp cc ON (cc.user_id = u.id AND DATE(cc.timestamp) = DATE(interval_start)) WHERE c.id = '" + custid + "' AND u.id = '" + intUID + "' GROUP BY user_name,call_date ORDER BY user_name,call_date;";
            }