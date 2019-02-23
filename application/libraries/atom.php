<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/Atompay-ci/Atompay/sample.php";
 
class Atom extends sample {

    public function __construct() {
        parent::__construct();
    }
}
 