<?php
class Campaign_prospect extends Eloquent {
	use CrudModel;

   public function getTimestampAttribute($attr) {        
        return Carbon\Carbon::parse($attr)->format('m/d/Y');
    }	
  public function getNextCallScheduledAttribute($attr) {        
        return Carbon\Carbon::parse($attr)->format('m/d/Y');
    }    
}