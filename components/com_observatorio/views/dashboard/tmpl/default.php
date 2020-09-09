<?php

$document = JFactory::getDocument();            // Document.

// Highchart
$document->addScript("https://code.highcharts.com/highcharts.js");
$document->addScript("https://code.highcharts.com/modules/exporting.js");
$document->addScript("https://code.highcharts.com/modules/export-data.js");
$document->addScript("https://code.highcharts.com/modules/no-data-to-display.js");


$document->addStyleSheet(JURI::base() . "components/com_observatorio/css/dashboard.css");
$document->addStyleSheet(JURI::base() . "templates/observatorio/libs/nice-select/nice-select.css");

$document->addScript(JURI::base() . "templates/observatorio/libs/nice-select/jquery.nice-select.js");
$document->addScript(JURI::base() . "components/com_observatorio/js/dashboard.js");
$document->addScript(JURI::base() . "components/com_observatorio/js/graphs_group_one.js");
$document->addScript(JURI::base() . "components/com_observatorio/js/graphs_group_two.js");
$document->addScript(JURI::base() . "components/com_observatorio/js/graphs.js");

?>

<input type="hidden" value="<?php echo JURI::base() ?>" id="host">

<div class="dashboard-main-container">

    <div class="navigation-container">

        <div class="menu-item-container active" id="menu-item-one" data-graph-group="one">
            <div class="menu-item-image">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/menu-blanco.svg'; ?>"
                     class="regular">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/menu-verde.svg'; ?>"
                     class="active">
            </div>
            <div class="menu-item-title">
                Inicio
            </div>
        </div>

        <div class="menu-item-container" id="menu-item-two" data-graph-group="two">
            <div class="menu-item-image">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/programas-blanco.svg'; ?>"
                     class="regular">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/programas-verde.svg'; ?>"
                     class="active">
            </div>
            <div class="menu-item-title">
                Programas Bienestar
            </div>
        </div>

        <div class="menu-item-container" id="menu-item-three" data-graph-group="three">
            <div class="menu-item-image">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/percepcion-blanco.svg'; ?>"
                     class="regular">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/percepcion-verde.svg'; ?>"
                     class="active">
            </div>
            <div class="menu-item-title">
                Percepción
            </div>
        </div>

        <div class="menu-item-container"  id="menu-item-four" data-graph-group="four">
            <div class="menu-item-image">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/modelos-blanco.svg'; ?>"
                     class="regular">
                <img src="<?php echo JURI::base() . 'components/com_observatorio/images/modelos-verde.svg'; ?>"
                     class="active">
            </div>
            <div class="menu-item-title">
                Modelos Bienestar
            </div>
        </div>

    </div>

    <div class="dashboard-content-container">

        <!-- Filters container -->
        <div class="filters-container">

            <!-- Range of dates -->
            <div class="date-selection filter-selector">

                <div class="filter-selected-info">
                    <div class="icon">
                        <img class="unactive" src="<?php echo JURI::base() . 'components/com_observatorio/images/calendario-azul.svg'; ?>">
                        <img class="active" src="<?php echo JURI::base() . 'components/com_observatorio/images/calendario-verde.svg'; ?>">
                    </div>

                    <div class="value">
                        Ene 2020 / Dic 2020
                    </div>

                    <div class="arrow-down"></div>
                </div>

                <div class="floating-window">
                    <div class="left-container">

                        <!-- Initial year -->
                        <div class="year-selector">
                            <div class="title">
                                Fecha Inicial
                            </div>

                            <select class="filters-select" id="initial-year">
                                <?php
                                $years = array();
                                foreach ($this->datesData as $index => $data):
                                    if (!in_array($data->year, $years)):
                                        array_push($years, $data->year);
                                        ?>
                                        <option value="<?php echo $data->year; ?>" <?php echo ($data->year == $this->lastRecordDate->year) ? 'selected' : ''; ?>>
                                            <?php echo $data->year; ?>
                                        </option>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>
                        </div>

                        <!-- Initial trimester -->
                        <div class="month-selector">
                            <div class="title">
                                Trimestre Inicial
                            </div>

                            <select class="filters-select" id="initial-trimester">
                                <option value="1" selected>1ro Ene - Mar</option>
                                <option value="2">2do Abr - Jun</option>
                                <option value="3">3ro Jul - Sep</option>
                                <option value="4">4to Oct - Dic</option>
                            </select>
                        </div>
                    </div>

                    <div class="right-container">

                        <!-- Final year -->
                        <div class="year-selector">
                            <div class="title">
                                Fecha Final
                            </div>

                            <select class="filters-select" id="final-year">
                                <?php
                                $years = array();
                                foreach ($this->datesData as $index => $data):
                                    if (!in_array($data->year, $years)):
                                        array_push($years, $data->year);
                                        ?>
                                        <option value="<?php echo $data->year; ?>" <?php echo ($data->year == $this->lastRecordDate->year) ? 'selected' : ''; ?>>
                                            <?php echo $data->year; ?>
                                        </option>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>
                        </div>

                        <!-- Final trimester -->
                        <div class="month-selector">
                            <div class="title">
                                Trimestre Final
                            </div>

                            <select class="filters-select" id="final-trimester">
                                <option value="1">1ro Ene - Mar</option>
                                <option value="2">2do Abr - Jun</option>
                                <option value="3">3ro Jul - Sep</option>
                                <option value="4">4to Oct - Dic</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Organization -->
            <div class="organization-selection filter-selector">

                <div class="filter-selected-info">
                    <div class="icon">
                        <img class="unactive" src="<?php echo JURI::base() . 'components/com_observatorio/images/organizacion-azul.svg'; ?>">
                        <img class="active" src="<?php echo JURI::base() . 'components/com_observatorio/images/organizacion-verde.svg'; ?>">
                    </div>

                    <div class="value">
                        Organización
                    </div>

                    <div class="arrow-down">

                    </div>
                </div>

                <div class="floating-window short organizations">

                    <div class="full-container">

                        <?php
                        foreach ($this->organizations as $organization):
                            ?>
                            <label class="checkbox-container"><?php echo $organization->organizacion; ?>
                                <input type="checkbox" name="organization[]">
                                <span class="checkmark"></span>
                            </label>
                            <?php
                        endforeach;
                        ?>

                    </div>

                </div>

            </div>
        </div>

        <div class="graphs-container">

            <div class="graph-group group-number-one">
                <!-- First row of graphs -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">

                            <!-- General numeric stats -->
                            <div class="col-md-12">
                                <div class="general-stats-container" id="general-one">
                                    <div class="title">Colaboradores</div>
                                    <div class="value"></div>
                                </div>

                                <div class="general-stats-container" id="general-two">
                                    <div class="title">Fuera de Riesgo</div>
                                    <div class="value"></div>
                                </div>

                                <div class="general-stats-container" id="general-three">
                                    <div class="title">En Riesgo</div>
                                    <div class="value"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card-graph-container">
                                    <div class="card-title">
                                        Población en Riesgo
                                    </div>
                                    <div id="graph-one">
                                        Gráficas
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title morbility-title">
                                Morbilidades
                            </div>
                            <div id="graph-two">
                                Gráficas
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Second row of graphs -->
                <div class="row">

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Atención Médica
                            </div>
                            <div id="graph-three">
                                Gráficas
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Atención Médica (Porcentaje)
                            </div>
                            <div id="graph-four">
                                Gráficas
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Morbilidades (Porcentaje)
                            </div>
                            <div id="graph-five">
                                Gráficas
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="graph-group group-number-two">
                <!-- First row of graphs -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card-graph-container">
                            <div class="card-title morbility-title">
                                Niveles de Cumplimiento
                            </div>
                            <div id="graph-21">
                                Gráficas
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Atención Médica
                            </div>
                            <div id="graph-12">
                                Gráficas
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Second row of graphs -->
                <div class="row">

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Atención Médica
                            </div>
                            <div id="graph-12">
                                Gráficas
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Atención Médica (Porcentaje)
                            </div>
                            <div id="graph-13">
                                Gráficas
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card-graph-container">
                            <div class="card-title">
                                Morbilidades (Porcentaje)
                            </div>
                            <div id="graph-14">
                                Gráficas
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>