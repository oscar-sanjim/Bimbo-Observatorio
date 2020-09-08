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

    /**
     * Gets the total of collaborators in risk and compares them to the grand total
     * @return array
     */
    public function getCollaboratorsInRisk(){
        $data = $this->model->groupGenericNumericValues($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear);
        $response = array(
            "total" => $data->total,
            "total_risk" => $data->total_risk,
            "percentage_risk" => ($data->total_risk * 100) / $data->total
        );
        return $response;

    }


    /**
     * Gets the total of cases grouped by "Morbilidad".
     * @return array
     */
    public function getTotalsByMorbidity(){
        $data = $this->model->groupByMorbility($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear);

        $total = 0;
        $morbidities = array();
        foreach ($data as $morbidityRow){
            foreach ($morbidityRow as $morbidity){
                if(in_array($morbidity->morbilidad_alias, $morbidities)){
                    $morbidities[$morbidity->morbilidad_alias] += $morbidity->morbilidad_total;

                }else{
                    $morbidities[$morbidity->morbilidad_alias] = $morbidity->morbilidad_total;

                }

                $total += $morbidity->morbilidad_total;
            }
        }

        $data = array();
        foreach ($morbidities as $key=>$value){
            array_push($data, array(
                "morbidity_alias" => $key,
                "morbidity_total" => $value
            ));
        }

        $response = array(
            "total" => $total,
            "morbidities" => $data
        );

        return $response;

    }


    /**
     * Retrieves the total number of collaborators under medical attention
     * @return array
     */
    public function getCollaboratorsUnderMedicalAttention(){
        $data = $this->model->getCollaboratorsUnderMedicalAttention($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, array());


        $response = $data;

        return $response;

    }
}