<?php

namespace App;
use \App\Firm;


Class Fund extends \App\FundDeffs {

    public $fundMemberTotal=0;

    function __construct()
    {

        parent::__construct();

        $firm = new Firm();

        $this->fundMemberTotal = $firm->FundMemberTotal;
    }
}