<?php
//language
class Expression{

  public $truValue;

  public $functionName;

  public $param1;

  public $param2;

  public $param3;

  public function _nand($lhs, $rhs) {
    return(!($lhs && $rhs));
  }

  public function _setTruValue($var){
    $this->truValue = $var;
  }

  //set the truValue to like true or false...
  public function _setFuncName($fName, $p1, $p2, $p3){
    $this->functionName = $fName;
    $this->param1 = $p1;
    $this->param2 = $p2;
    $this->param3 = $p3;

    return $this;
  }

}

/*
This is the STD. Library
gets of type Expression
*/
class StdLib  extends Expression{



  public function orTru($lhs, $rhs){
    return($lhs->truValue || $rhs->truValue);
  }

  public function ndTru($lhs, $rhs){
    return ($lhs->truValue && $rhs->truValue);
  }

  public function notTru($val){
    return (!$val->truValue);
  }

  public function norTru($lhs, $rhs){
      return(!($lhs->truValue || $rhs->truValue));
  }

  public function xnorTru($lhs, $rhs){
    $expr = new Expression();
    $G1 =  $expr->_nand($lhs->truValue, $rhs->truValue);
    $G2 =  $expr->_nand($lhs->truValue, $G1);
    $G3 =  $expr->_nand($G1,  $rhs->truValue);
    $G4 =  $expr->_nand($G2,  $G3);
    $G5 =  $expr->_nand($G4, $G4);
    return $G5;
  }

  public function xorTru($lhs, $rhs){
    $expr = new Expression();
    $G1 =  $expr->_nand($lhs->truValue, $rhs->truValue);
    $G2 =  $expr->_nand($lhs->truValue, $G1);
    $G3 =  $expr->_nand($G1,  $rhs->truValue);
    $G4 =  $expr->_nand($G2,  $G3);
    return $G4;
  }

  public function implies($lhs, $rhs){
    return ( ($lhs->truValue == true) && ($rhs->truValue == true));
  }

  public function equalTru($lhs, $rhs){
    return($lhs == $rhs);
  }


  public function majority($lhs, $mid, $rhs){
    if( ($lhs == $rhs) || ($lhs == $mid)){
      return $lhs->truValue;
    }
    else{
      return $mid->truValue;
    }
  }



}

//actual truing definition is initializing the class
$_stdLib = new StdLib();
$expr = new Expression();

$truVal = new Expression();
$falsVal = new Expression();

$truVal->_setTruValue(true);
$falsVal->_setTruValue(false);



//declaring the variables before putting it in.
//----------------------------------------------------------------TESTING---------------------------------------------------------------------------------

//or truth table
assert((interp((new Expression())->_setFuncName("or", $truVal, $falsVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("or", $falsVal, $truVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("or", $truVal, $truVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("or", $falsVal, $falsVal, null))) ==  false);

//and truth table
assert((interp((new Expression())->_setFuncName("and", $truVal, $falsVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("and", $falsVal, $truVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("and", $truVal, $truVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("and", $falsVal, $falsVal, null))) ==  false);

//npt truth table
assert((interp((new Expression())->_setFuncName("not", $truVal, null, null))) ==  false);
assert((interp((new Expression())->_setFuncName("not", $falsVal, null, null))) ==  true);

//xor
assert((interp((new Expression())->_setFuncName("xor", $truVal, $falsVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("xor", $falsVal, $truVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("xor", $truVal, $truVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("xor", $falsVal, $falsVal, null))) ==  false);


//xnor
assert((interp((new Expression())->_setFuncName("xnor", $truVal, $falsVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("xnor", $falsVal, $truVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("xnor", $truVal, $truVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("xnor", $falsVal, $falsVal, null))) ==  true);

//equals
assert((interp((new Expression())->_setFuncName("equals", $falsVal, $truVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("equals", $truVal, $truVal, null))) ==  true);

//implies
assert((interp((new Expression())->_setFuncName("implies", $truVal, $falsVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("implies", $falsVal, $truVal, null))) ==  false);
assert((interp((new Expression())->_setFuncName("implies", $truVal, $truVal, null))) ==  true);
assert((interp((new Expression())->_setFuncName("implies", $falsVal, $falsVal, null))) ==  false);

//majority
assert((interp((new Expression())->_setFuncName("majority", $truVal, $falsVal, $truVal))) ==  true);
assert((interp((new Expression())->_setFuncName("majority", $falsVal, $falsVal, $truVal))) ==  false);
assert((interp((new Expression())->_setFuncName("majority", $truVal, $truVal, $truVal))) ==  true);
assert((interp((new Expression())->_setFuncName("majority", $falsVal, $falsVal, $falsVal))) ==  false);


//--------------------------------------------------interpreter---------------------------------------------------------------------------------
function interp($obj){
  global $_stdLib;
  switch ($obj->functionName){
    case "or":
        return $_stdLib->orTru($obj->param1, $obj->param2);
        break;
    case "and":
        return $_stdLib->ndTru($obj->param1, $obj->param2);
        break;
    case "not":
        return $_stdLib->notTru($obj->param1);
        break;
    case "xnor":
        return $_stdLib->xnorTru($obj->param1, $obj->param2);
         break;
   case "xor":
       return $_stdLib->xorTru($obj->param1, $obj->param2);
       break;
   case "equals":
       return $_stdLib->equalTru($obj->param1, $obj->param2);
       break;
   case "implies":
        return $_stdLib->implies($obj->param1, $obj->param2);
        break;
  case "majority":
        return $_stdLib->majority($obj->param1, $obj->param2, $obj->param3);
        break;

  }
}

//var_dump($orTest);

//echo $orTest->param1;


//based on class creation we will interp the function


?>
