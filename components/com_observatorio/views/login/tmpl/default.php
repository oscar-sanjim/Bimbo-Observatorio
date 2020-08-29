<?php

$document = JFactory::getDocument();            // Document.
$document->addStyleSheet(JURI::base() . "components/com_observatorio/css/login.css");

?>

<div class="login-page-container">
    <div class="content-limiter">
        <div class="form-container">
            <div class="logo-container">
                Logo
            </div>

            <form method="POST">
                <div class="input-container">
                    <img src="<?php echo JURI::base() . 'components/com_observatorio/images/mail.png'; ?>">
                    <input type="email" name="email" placeholder="Correo electrónico">
                </div>

                <div class="input-container">
                    <img src="<?php echo JURI::base() . 'components/com_observatorio/images/mail.png'; ?>">
                    <input type="password" name="password" placeholder="Contraseña">
                </div>

                <input type="hidden" name="option" value="com_observatorio">
                <input type="hidden" name="task" value="loginUser">

                <input type="submit" class="submit-button" value="Entrar">
            </form>

            <div class="lost-password">
                Olvidé mi contraseña
            </div>
        </div>
    </div>
</div>
