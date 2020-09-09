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
            "percentage_risk" => ($data->total > 0 ) ? ($data->total_risk * 100) / $data->total : 0
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

    /**
     * Retrieves the compliance levels by organization
     * @return array
     */
    public function getComplianceLevels(){
        $data = $this->model->getComplianceLevelsByOrganization($this->intialTrim, $this->finalTrim, $this->intialYear, $this->finalYear, array());
        $organizationsData = array();

        foreach($data as $record){

            // Create the record for the org. if not available.
            if(array_key_exists($record->organizacion, $organizationsData) == false){
                $organizationsData[$record->organizacion] = array();

            }

            array_push($organizationsData[$record->organizacion], array(
                "nivel_cumplimiento" => $record->nivel_cumplimiento,
                "year" => $record->year,
                "trimester" => $record->trimester
            ));

        }

        $response = $organizationsData;

        return $response;
    }
}