<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class manga_list extends Eloquent {
	protected $Name='Name';
	protected $Autor = 'Autor';
	protected $Published = ['Published'];
	protected $Volume = ['Volume'];
	protected $Status = ['Status'];
	protected $id= 'id';
	protected $Description = ['Description'];
	public $timestamps = false;
	
}
