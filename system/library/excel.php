<?php
require_once DIR_SYSTEM . 'excel/PHPExcel.php';

final class Excel {

	/**
	 * Excel5,Excel2007
	 */
	private $format;

	private $excel;
	private $sheet;
	private $rownum;

	private $columntype;
	private $columnmap;

	function __construct($fmt='Excel5'){
		$this->format=$fmt;
		$this->excel=new PHPExcel();
		$this->sheet=$this->excel->getActiveSheet();
		$this->rownum=1;
		$this->columnmap=array();
		$words='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$l=strlen($words);
		for ($i=0; $i < $l; $i++) { 
			$this->columnmap[]=substr($words, $i, 1);
		}
		for ($i=0; $i < $l; $i++) { 
			for ($j=0; $j < $l; $j++) { 
				$this->columnmap[]=$this->columnmap[$i].$this->columnmap[$j];
			}
		}
		$this->columntype=array();
	}

	function getExcel(){
		return $this->excel;
	}

	function getSheet(){
		return $this->sheet;
	}

	function setInfo($info){
		$prop=$this->excel->getProperties();
		if(isset($info['creator']))$prop->setCreator($info['creator']);
		if(isset($info['modified_by']))$prop->setLastModifiedBy($info['modified_by']);
		if(isset($info['title']))$prop->setTitle($info['title']);
		if(isset($info['subject']))$prop->setSubject($info['subject']);
		if(isset($info['description']))$prop->setDescription($info['description']);
		if(isset($info['keywords']))$prop->setKeywords($info['keywords']);
		if(isset($info['category']))$prop->setCategory($info['category']);
	}

	function setColumnType($column,$type){
		if(is_numeric($column)){
			$column=$this->columntype[$column];
		}
		$this->columntype[$column]=$type;
	}

	function setTitle($title){
		$this->sheet->setTitle($title);
	}

	function setPageHeader($header='&C&B&TITLE'){
		$this->sheet->getHeaderFooter()->setOddHeader(str_replace('&TITLE',$this->excel->getProperties()->getTitle(),$header));

	}

	function setPageFooter($footer='&L&TITLE &RPage &P of &N'){
		$this->sheet->getHeaderFooter()->setOddFooter(str_replace('&TITLE',$this->excel->getProperties()->getTitle(),$footer));
	}

	/**
	 * 设置表头,其实与设置行一样，以后会增加其它功能
	 */
	function setHeader($header=array()){
		$i=0;
		foreach ($header as $key => $value) {
			$this->sheet->setCellValueExplicit($this->columnmap[$i].$this->rownum,$value);
			$i++;
		}
		$this->rownum++;
	}

	function addRow($row){
		$i=0;
		foreach ($row as $key => $value) {
			if(isset($this->columntype[$this->columnmap[$i]])){
				$this->sheet->setCellValueExplicit($this->columnmap[$i].$this->rownum,$value,$this->columntype[$this->columnmap[$i]]);
			}else{
				$this->sheet->setCellValue($this->columnmap[$i].$this->rownum,$value);
			}
			$i++;
		}
		$this->rownum++;
	}

	/**
	 * 删除行,默认删除尾行
	 */
	function delRow($row=null, $num=1){
		if(is_null($row)){
			$row=$this->rownum;
		}
		$this->sheet->removeRow($row,$num);
		$this->rownum -= $num;
	}

	/**
	 * 清空,是否清空表头
	 */
	function clear($wh=false){
		$this->sheet->removeRow($wh?1:2,$this->rownum);
		$this->rownum=$wh?1:2;
	}

	/**
	 * 保存到文件
	 * @return TRUE/FALSE
	 */
	function saveTo($path){
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, $this->format);
		$objWriter->save($path);
	}

	/**
	 * 输出
	 * @param 文件名
	 */
	function output($filename=''){
		if(!is_dir(DIR_SYSTEM.'cache/excel')){
			mkdir(DIR_SYSTEM.'cache/excel',0777,TRUE);
		}
		$path=DIR_SYSTEM.'cache/excel/'.base_convert(microtime(), 10, 32).'-'.$filename;
		$this->saveTo($path);
		$file = fopen($path,"r"); // 打开文件
		$size=filesize($path);
		// 输入文件标签
		Header("Content-type: application/vnd.ms-excel");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: ".$size);
		Header("Content-Disposition: attachment; filename=" . $filename);
		// 输出文件内容
		echo fread($file,$size);
		fclose($file);
		unlink($path);
		exit();
	}
}