<?php

require_once 'pronouns.civix.php';
use CRM_Pronouns_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function pronouns_civicrm_config(&$config) {
  _pronouns_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function pronouns_civicrm_xmlMenu(&$files) {
  _pronouns_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function pronouns_civicrm_install() {
  _pronouns_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function pronouns_civicrm_postInstall() {
  _pronouns_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function pronouns_civicrm_uninstall() {
  _pronouns_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function pronouns_civicrm_enable() {
  _pronouns_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function pronouns_civicrm_disable() {
  _pronouns_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function pronouns_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _pronouns_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function pronouns_civicrm_managed(&$entities) {
  _pronouns_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function pronouns_civicrm_caseTypes(&$caseTypes) {
  _pronouns_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function pronouns_civicrm_angularModules(&$angularModules) {
  _pronouns_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function pronouns_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _pronouns_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function pronouns_civicrm_entityTypes(&$entityTypes) {
  _pronouns_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function pronouns_civicrm_themes(&$themes) {
  _pronouns_civix_civicrm_themes($themes);
}

function pronouns_civicrm_buildForm($formName, $form) {
  if ($formName != 'CRM_Contribute_Form_Contribution_Confirm' || $formName == 'CRM_Contribute_Form_Contribution_ThankYou') {
    if ($formName == 'CRM_Profile_Form_Edit') {
      $profile = TRUE;
    }
    else {
      $profile = FALSE;
    }
    CRM_Core_Resources::singleton()->addVars('pronouns', ['profile' => $profile]);
    $options = [];
    $pronounOptions = civicrm_api3('OptionValue', 'get', ['option_group_id' => 'pronouns', ['return' => ['label', 'value']]]);
    foreach ($pronounOptions['values'] as $option) {
      $options[$option['value']] = $option['label'];
    }
    $options[] = E::ts('Other');
    $customField = civicrm_api3('CustomField', 'get', ['name' => 'pronoun']);
    if ($form->elementExists('custom_' . $customField['id'])) {
      $currentClass = $form->getElement('custom_' . $customField['id'])->getAttribute('class');
      if (!empty($currentClass)) {
        $currentClass .= ' ';
      }
      $currentClass .= 'pronoun_custom_field_text_box';
      $form->getElement('custom_' . $customField['id'])->updateAttributes(['class' => $currentClass]);
      $form->addElement('Select', 'pronoun_options', ts('Pronouns'),
        [
          0 => ts('- select -'),
        ] + $options,
        FALSE,
        ['class' => "crm-select2"]
      );
      CRM_Core_Region::instance('form-bottom')->add(array(
        'template' => 'pronoun_options.tpl'
       ));
      CRM_Core_Resources::singleton()->addScriptFile('au.org.greens.pronouns', 'js/pronoun.js');
    }
  }
}
 

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function pronouns_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function pronouns_civicrm_navigationMenu(&$menu) {
  _pronouns_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _pronouns_civix_navigationMenu($menu);
} // */
