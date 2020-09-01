<?php

class Graphs{

    function __construct($model, $intialTrim, $finalTrim, $intialYear, $finalYear)
    {
        $this->model = $model;
        $this->intialTrim = $intialTrim;
        $this->finalTrim = $finalTrim;
        $this->intialYear = $intialYear;
        $this->finalYear = $finalYear;

    }

    public function getColaboratorsInRisk(){
        $data = $this->model->groupGenericNumericValues($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear);
        $response = array(
            "total" => $data->total,
            "total_risk" => $data->total_risk,
            "percentage_risk" => ($data->total_risk * 100) / $data->total
        );
        return $response;

    }
}