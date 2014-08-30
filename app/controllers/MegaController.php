<?php
class MegaController extends BaseController {

protected $layout = 'master';

public function getIndex() {
	return 'Mega Index';
}

public function getTest() {
	$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("WW Job Manager")
   ->setLastModifiedBy("WW Job Manager")
   ->setTitle("Site List")
   ->setSubject("Site List")
   ->setDescription("Site List - ");

$data[] = array('id' => 13,'Notes' => 'mega', 'Aaa' => 666, 'Bbbb' => 13, 'Cccc' => 'lll','Ddd' => 'ada' );
$data[] = array('id' => 133,'Notes' => '24mega', 'Aaa' => 6466, 'Bbbb' => 143, 'Cccc' => 'l435ll','Ddd' => 'a5da' );
$data[] = array('id' => 143,'Notes' => 'mega44', 'Aaa' => 6266, 'Bbbb' => 153, 'Cccc' => 'l3ll','Ddd' => 'a554da' );

$alphas = range('A', 'Z');
$i = 0;
foreach($data[0] as $key => $v) {
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].'1', $key);
   // take note of the column index where Notes are kept for use in generating a Comment
   if ('Notes' == $key) {
      $notes_column_idx = $i;
   }
   $i++;
}

$row_i = 2;
foreach ($data as $row) {
   $i=0;
   foreach($row as $col) {
      $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphas[$i].$row_i, $col);
      // if this is the Notes column, then put the notes as a comment to cell of this row
      // in Column E
      if ($notes_column_idx == $i) {
         $objPHPExcel->getActiveSheet(0)
            ->getComment('E'.$row_i)
            ->setAuthor('WW AutoGen')
            ->getText()->createTextRun($col);
      }
      $i++;
   }
   $row_i++;
}

// for each of the columns in our sheet, set the column autosize on
$i = 0;
foreach($data[0] as $key => $v) {
   $objPHPExcel->getActiveSheet(0)->getColumnDimension($alphas[$i])->setAutoSize(true);
   $i++;
}
// Set auto filters for the full range of our data and header row.
$objPHPExcel->getActiveSheet(0)->setAutoFilter($alphas[0].'1:'.$alphas[$i].$row_i);

$tmpfname = 'booo';
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($tmpfname.'.xls');



	return "test Index";
}

public function getHome($id=66,$id2) {
	return "test $id $id2 -";
}

public function getMega() {

$validator = Validator::make(
    array(
        'name' => '',
        'page' => 'd',
        'password' => 'lamepassword',
        'email' => 'email@example.com'
    ),
    array(
        'name' => 'required',
        'fname' => 'required',
        'password' => 'required|min:8',
        'email' => 'required|email'
    )
);
if ($validator->fails())
{
	
	print_r($validator->messages());exit;
}
	return "-= test -=";
}

public function getTestdb() {
	
	
	$data['list'] = Campaign::take(4)->offset(3)->get()->toarray();
	//$campaigns = Campaign::paginate(15);

	//$data['pag'] = $campaigns;
	//$data['list'] = $campaigns;
	Paginator::setCurrentPage(2);
	$pag = Paginator::make(array('id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1,'id'=>1), 1000, 10); 
	
	$data['pag'] = $pag;
	
	$this->layout->content = View::make('campaign',$data);
}


public function getView() {
	$data = array(
		'crud_title' => 'Testing',
		'crud_model' => 'Campaign',
		'crud_sort' => '',
		'crud_order' => '',
		'crud_page' => '1',

		'crud_auto_filter' => true
		);

	$this->layout->content = View::make('crud.view',$data);	
}

}
?>