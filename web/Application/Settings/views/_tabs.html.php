<ul class="nav nav-tabs">
    <?php if(!array_intersect(array('Superadmin'), $loggedUser['roles']) && array_intersect(array('settings'), $loggedUser['modules'])):?>
        <!-- Settings / Setari -->
        <li class="<?php echo (isset($template['method']) && $template['method'] == 'settings') ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/settings/settings">Setări</a>
        </li>
    <?php endif;?>

    <?php if(array_intersect(array('Superadmin'), $loggedUser['roles'])):?>
        <!-- Global settings / Setari globale -->
        <li class="<?php echo (isset($template['method']) && $template['method'] == 'global_settings') ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/settings/global_settings">Setări globale</a>
        </li>
    <?php endif;?>

    <?php if(!array_intersect(array('Superadmin'), $loggedUser['roles']) && array_intersect(array('users'), $loggedUser['modules']) && $loggedUser['account_type'] == \Application\Accounts\AccountsModel::TYPE_LAW_FIRM):?>
        <!-- Utilizatori -->
        <li class="<?php echo (isset($template['method']) && isset($template['module']) && in_array($template['module'], array('users'))) ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/users/index">Utilizatori</a>
        </li>
    <?php endif;?>

    <?php if(!array_intersect(array('Superadmin'), $loggedUser['roles']) && array_intersect(array('settings'), $loggedUser['modules']) && $loggedUser['account_type'] == \Application\Accounts\AccountsModel::TYPE_LAW_FIRM):?>
        <!-- Roles / Roluri -->
        <li class="<?php echo (isset($template['method']) && $template['method'] == 'roles') ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/roles/roles">Roluri</a>
        </li>
    <?php endif;?>

    <?php if(array_intersect(array('Superadmin'), $loggedUser['roles'])):?>
        <!-- Global roles / Roluri globale -->
        <li class="<?php echo (isset($template['method']) && $template['method'] == 'global_roles') ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/roles/global_roles">Roluri globale</a>
        </li>
    <?php endif;?>

    <?php if(array_intersect(array('Superadmin'), $loggedUser['roles'])):?>
        <li class="<?php echo (isset($template['method']) && $template['method'] == 'checkpoints') ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/settings/checkpoints">Checkpoints</a>
        </li>
    <?php endif;?>

    <?php if(array_intersect(array('Superadmin'), $loggedUser['roles'])):?>
        <li class="<?php echo (isset($template['method']) && isset($template['activeTab']) && $template['activeTab'] == 'errors') ? 'active' : null ?>">
            <a href="<?php echo BASE_URL?>/errors/index">Erori sistem</a>
        </li>
    <?php endif;?>
</ul>