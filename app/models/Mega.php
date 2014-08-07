<?php

class Mega {
	static function test() {
		$result = DB::select('select ? as `boo`,? as `t` from dual
								union 
								select 567 as `boo`, 345 as `t` from dual
								',array(1,666));
		
		return camel_case('Model_Test ').str_plural('wolf');
	}
}