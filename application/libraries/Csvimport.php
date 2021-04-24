<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/*
*CODEGINETOR CSV IMPORT FILE
*THIS LIBRARY WILL HELP YOU TO IMPORT A CSV FILE IN TO A ASSOCIATIVE ARRAY
*
*/


class Csvimport{

	private $handle              = "";
	private $filepath            = FALSE;
	private $column_headers      = FALSE;
	private $initial_line        = 0;
	private $delimiter           = ",";
	private $detect_line_endings = FALSE;
}
?>