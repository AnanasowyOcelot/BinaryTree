<?php

//function RandomNumbersFromRange($min, $max, $range) {
//    $numbers = range($min, $max);
//    shuffle($numbers);
//    return array_slice($numbers, 0, $range);
//}
//
//$randomArr = RandomNumbersFromRange(1, 20, 1000);
//for($i=0; $i<count($randomArr); $i++){
//    echo($randomArr[$i].", ");
//}

$randomNumString = "19, 17, 1, 7, 10, 8, 4, 5, 12, 20, 9, 15, 3, 13, 6, 18, 14, 11, 2, 16";

$randomNumArr = explode(", ", $randomNumString);

//print_r($randomNumArr);

class Node
{
    public $value = 0;
    public $leftNode;
    public $rightNode;
    public $topNode;
}

class TreeCreator
{
    public $randomNumString = "19, 17, 1, 7, 10, 8, 4, 5, 12, 20, 9, 15, 3, 13, 6, 18, 14, 11, 2, 16";

    public function arrayFromStrint()
    {
        $string = $this->randomNumString;
        $randomNumArr = explode(", ", $string);
        return $randomNumArr;
    }

    public function createTreeArr()
    {
        $randomNumArr = $this->arrayFromStrint();
        $root = new Node();
        $root->value = $randomNumArr[0];
        for ($i = 1; $i < count($randomNumArr); $i++) {
            $node = new Node();
            $node->value = $randomNumArr[$i];
            $this->placeNewNode($root, $node);
        }
        return $root;
    }

    function placeNewNode(Node $currentNode, Node $newNode)
    {
        if ($currentNode->value > $newNode->value) {

            if (!isset($currentNode->leftNode)) {
                $currentNode->leftNode = $newNode;
            } else {
                $this->placeNewNode($currentNode->leftNode, $newNode);
            }
        } elseif ($currentNode->value < $newNode->value) {

            if (!isset($currentNode->rightNode)) {
                $currentNode->rightNode = $newNode;
            } else {
                $this->placeNewNode($currentNode->rightNode, $newNode);
            }
        }
    }
}


class TreeRenderer
{
    private $arrayOfNodeLvls = array();
    private $html;
    private $htmlHeight = 100;

    public function display(Node $node)
    {
        //$this->sortNodesByLevel($node);
        $this->renderTree($node);
        return $this->html;
    }

    private function renderTree(Node $node = null)
    {
        if ($node != null) {
            $this->html .= "<table height='" . $this->htmlHeight . "%'>";

            $this->htmlHeight = $this->htmlHeight / 2 - 5;

            $this->html .= "<tr><td rowspan='2'>" . $node->value . "</td><td>";
            $this->renderTree($node->leftNode);
            $this->html .= "</td></tr>";
            $this->html .= "<tr><td>";
            $this->renderTree($node->rightNode);
            $this->html .= "</td></tr>";
            $this->html .= "</table>";

        }

    }

    private function sortNodesByLevel(Node $node = null, $lvl = 0)
    {
        if ($node !== null) {
            $this->saveVal($node->value, $lvl);
            $this->sortNodesByLevel($node->leftNode, $lvl + 1);
            $this->sortNodesByLevel($node->rightNode, $lvl + 1);
        }
    }

    private function saveVal($val, $lvl)
    {
        if (!isset($this->arrayOfNodeLvls[$lvl])) {
            $this->arrayOfNodeLvls[$lvl] = array();
        }
        $this->arrayOfNodeLvls[$lvl][] = $val;
    }
}

class BalanceTree
{
    public $subtreeHeightR;
    public $subtreeHeightL;


    public function getRightSubtreeHeight(Node $node = null)
    {
        if ($node != null) {
            $this->subtreeHeightR++;
            $this->getRightSubtreeHeight($node->rightNode);
        } else {
            return $this->subtreeHeightR;
        }
    }
    public function getLeftSubtreeHeight(Node $node = null){
        if($node != null){
            $this->subtreeHeightL++;
            $this->getLeftSubtreeHeight($node->leftNode);
        }else{
            return $this->subtreeHeightL;
        }
    }
    public function getBalanceFactor(Node $node){
        $leftHeight = $this->getLeftSubtreeHeight($node);
        $rightHeight = $this->getRightSubtreeHeight($node);

        if($leftHeight > $rightHeight){
            return $leftHeight;
        }else{
            return $rightHeight;
        }
    }
}


$TC = new TreeCreator();
$root = $TC->createTreeArr();
$DT = new TreeRenderer();
echo "<style>tr, td{border:1px solid black; font-size: 25px;}</style>";
echo $DT->display($root);
