<?php

$document = JFactory::getDocument();            // Document.
$document->addStyleSheet(JURI::base() . "components/com_observatorio/css/dashboard.css");
$document->addStyleSheet(JURI::base() . "templates/observatorio/libs/nice-select/nice-select.css");

$document->addScript(JURI::base() . "templates/observatorio/libs/nice-select/jquery.nice-select.js");
$document->addScript(JURI::base() . "components/com_observatorio/js/dashboard.js");
$document->addScript(JURI::base() . "components/com_observatorio/js/graphs.js");

?>

<input type="hidden" value="<?php echo JURI::base()?>" id="host">

<div class="dashboard-main-container">

    <div class="navigation-container">

        <div class="menu-item-container active">
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

        <div class="menu-item-container">
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

        <div class="menu-item-container">
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

        <div class="menu-item-container">
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
                        <img src="<?php echo JURI::base() . 'components/com_observatorio/images/calendario-azul.svg'; ?>">
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
                                <option>2018</option>
                                <option>2019</option>
                                <option selected>2020</option>
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

                            <select class="filters-select"  id="final-year">
                                <option>2018</option>
                                <option>2019</option>
                                <option selected>2020</option>
                            </select>
                        </div>

                        <!-- Final trimester -->
                        <div class="month-selector">
                            <div class="title">
                                Trimestre Final
                            </div>

                            <select class="filters-select"  id="final-trimester">
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
                        <img src="<?php echo JURI::base() . 'components/com_observatorio/images/organizacion-azul.svg'; ?>">
                    </div>

                    <div class="value">
                        Organización
                    </div>

                    <div class="arrow-down">

                    </div>
                </div>

                <div class="floating-window short">

                    <div class="full-container">

                        <label class="checkbox-container">BM
                            <input type="checkbox" name="organization-">
                            <span class="checkmark"></span>
                        </label>

                        <label class="checkbox-container">BL
                            <input type="checkbox" name="organization-">
                            <span class="checkmark"></span>
                        </label>

                        <label class="checkbox-container">Ricolino
                            <input type="checkbox" name="organization-">
                            <span class="checkmark"></span>
                        </label>

                        <label class="checkbox-container">El Globo
                            <input type="checkbox" name="organization-">
                            <span class="checkmark"></span>
                        </label>

                        <label class="checkbox-container">Moldex
                            <input type="checkbox" name="organization-">
                            <span class="checkmark"></span>
                        </label>

                        <label class="checkbox-container">Corporativo
                            <input type="checkbox" name="organization-">
                            <span class="checkmark"></span>
                        </label>

                    </div>

                </div>

            </div>
        </div>

        <div class="graphs-container">

            <!-- First row of graphs -->
            <div class="row">
                <div class="col-md-7">
                    <div class="row">

                        <!-- General numeric stats -->
                        <div class="col-md-12">
                            <div class="general-stats-container" id="general-one">
                                <div class="title">Colaboradores</div>
                                <div class="value">1000</div>
                            </div>

                            <div class="general-stats-container" id="general-two">
                                <div class="title">En Riesgo</div>
                                <div class="value">2000</div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card-graph-container">
                                <div class="card-title">
                                    Título
                                </div>
                                Gráficas
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card-graph-container">
                        <div class="card-title">
                            Título
                        </div>
                        Gráficas
                    </div>
                </div>
            </div>


            <!-- Second row of graphs -->
            <div class="row">

                <div class="col-md-4">
                    <div class="card-graph-container">
                        <div class="card-title">
                            Título
                        </div>
                        Gráficas
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-graph-container">
                        <div class="card-title">
                            Título
                        </div>
                        Gráficas
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card-graph-container">
                        <div class="card-title">
                            Título
                        </div>
                        Gráficas
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>