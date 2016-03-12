                <ul class="nav nav-tabs">

                    <!-- Personal informations / Date personale -->
                    <li class="<?php echo (isset($template['method']) && $template['method'] == 'personal_informations') ? 'active' : null ?>">
                        <a href="<?php echo BASE_URL?>/users/personal_informations">Date personale</a>
                    </li>

                    <!-- Contact informations / Date de contact -->
                    <li class="<?php echo (isset($template['method']) && $template['method'] == 'contact_informations') ? 'active' : null ?>">
                        <a href="<?php echo BASE_URL?>/users/contact_informations">Date de contact</a>
                    </li>

                    <!-- Credensials / Date de acces -->
                    <li class="<?php echo (isset($template['method']) && $template['method'] == 'credensials') ? 'active' : null ?>">
                        <a href="<?php echo BASE_URL?>/users/credensials">Date de acces</a>
                    </li>

                    <!-- Credensials / Notificari -->
                    <li class="<?php echo (isset($template['method']) && $template['method'] == 'notifications') ? 'active' : null ?>">
                        <a href="#">Notificari</a>
                    </li>

                </ul>