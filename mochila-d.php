<?php

class Knapsack {
    
    private $capacity = 0;
    private $weightValue = array();
    public $buffer = array();
    
    function __construct($params = array()) {
        $this->capacity = $params['c'];
        $this->weightValue = $this->mergeArrays($params);
    }
    
    function mergeArrays($params = array()) {
        array_unshift($params['w'], '0');
        array_unshift($params['v'], '0');
        //$return = array_combine($params['w'], $params['v']);
       
       #para pegar o valor maior quando peso é repetido
        foreach ($params['w'] as $key => $weight) {
            $return[$weight] = $return[$weight] > $params['v'][$key] ? $return[$weight] : $params['v'][$key];
        }
        ksort($return);
        return $return;
    }
    
    function generateTable() {
        $table = "<table  class='table table-bordered table-striped'><tbody>";
        $table .= "<tr>";
        $table .= "<td><strong>X</strong></td>";
        #peso da mochila
        for ($i=0; $i<=$this->capacity; $i++){
            $table .= "<th>$i</th>";
                
        }
        $table .= "</tr>";
       
        
        foreach ($this->weightValue as $key => $value) {
            $table .= "<tr>";
            $table .= "<td><strong>$key</strong></td>";
            for ($i=0; $i<=$this->capacity; $i++){
                $table .= "<td>{$this->calculateValue($key, $i)}</td>";
                
            }
            $table .= "</tr>";
        }
        $table .= "</tbody></table>";
        
        return $table;
    }
    #calcula o peso e ve qual mochila esta 
    function calculateValue($weight = 0, $bpCurrentWeight = 0) {
        if ($weight == 0 || $bpCurrentWeight == 0) {
            $return = 0;
        } elseif ($weight <= $bpCurrentWeight) {
            $positionToSum = $bpCurrentWeight - $weight;
            $valueToSum = $this->getPreviousValue(($weight-1),$positionToSum);
            $valueAbove = $this->getPreviousValue(($weight-1), $bpCurrentWeight);
            $currentValue = $this->weightValue[$weight] + $valueToSum;
            $return = $currentValue >= $valueAbove ? $currentValue : $valueAbove;
        } else {
            $return = $this->getPreviousValue(($weight-1), $bpCurrentWeight);
        }
        
        $this->buffer[$weight][$bpCurrentWeight] = $return;
        
        return $return;
    }
    
    function generateChosenItemsTable() {
        if (!count($this->buffer)) {
            echo "<b>Sem dados para c&aacute;lculos.</b>";
            return;
        }
        $items = $this->getChosenItems();
        
        if (!count($items)) {
            echo "<b>Nenhum item cabe na mochila.</b>";
            return;
        }
        $table = "<table class='table table-bordered'><tbody>";
        $table .= "<tr><th>Peso</th><th>Valor</th></tr>";
        foreach ($items as $weight => $value) {
            $table .= "<tr>";
            $table .= "<td>$weight</td>";
            $table .= "<td>$value</td>";
            $table .= "</tr>";
            $totalWeight += $weight;
            $totalValue += $value;
        }
        $table .= "<tr><th colspan='2'>Total</th></tr>";
        $table .= "<tr>";
        $table .= "<th>$totalWeight</th >";
        $table .= "<th>$totalValue</th>";
        $table .= "</tr>";
        $table .= "</tbody></table>";
        
        return $table;
    }
    
    function getChosenItems() {
        $chosen = array();
       
        $this->checkChosen($chosen, $this->getHigherValue($this->buffer), $this->capacity);
        
        return $chosen;
    }
    
    function getHigherValue($valueArray = array()) {
        $return = 0;
        $val = 0;
        foreach($valueArray as $k => $v) {
            $v = end($v);
            
            if ($v > $val) {
                $return = $k;
                $val = $v;
            }
        }
        
        return $return;
    }
    
    function checkChosen(&$chosen, $itemWeight, $currentCapacity) {
        $previousItemWeight = $this->getPreviousValue(($itemWeight - 1), 0, true);

        $currentValue = $this->buffer[$itemWeight][$currentCapacity];
        $previousWeightValue = $this->getPreviousValue($previousItemWeight, $currentCapacity);
        
        if ($currentValue != $previousWeightValue) {
            $chosen[$itemWeight] = $this->weightValue[$itemWeight];
            $currentCapacity = ($currentCapacity - $itemWeight) < 0 ? 0 : $currentCapacity - $itemWeight;
        }
        
        if ($previousItemWeight == 0 ) {
            return;
        }
        
        $this->checkChosen($chosen, $previousItemWeight, $currentCapacity);
    }
    
    function getPreviousValue($currentWeight, $position, $keyOnly = false) {
        if ($currentWeight <= 0) {
            return 0;
        }
        
        if (isset($this->buffer[$currentWeight])) {
            if ($keyOnly == false) {
                return $this->buffer[$currentWeight][$position];
            }
            return $currentWeight;
        }
        return $this->getPreviousValue(($currentWeight-1), $position, $keyOnly);
    }
}