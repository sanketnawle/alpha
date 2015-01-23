<?php

class Paginator{
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $default_ipp = 25;

	function Paginator($limit, $totalNumber)
	{
		$this->current_page = 1;
		$this->items_total = $totalNumber;
		$this->items_per_page = $limit;
	}

	function paginate($page)
	{
		$this->num_pages = ceil($this->items_total/$this->items_per_page);
		$this->current_page = $page; 
		if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
		$prev_page = $this->current_page-1;
		$next_page = $this->current_page+1;
		$this->low = ($this->current_page-1) * $this->items_per_page;
		$this->high = ($this->current_page * $this->items_per_page)-1;
		$this->limit = "LIMIT $this->low,$this->items_per_page";
		return $this->limit;
	}
	
	function getOffset()
	{
		return $this->low;
	}
	
	function getLimit()
	{
		return $this->limit;
	}
}