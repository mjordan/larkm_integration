<?php

namespace Drupal\larkm_integration\Plugin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Admin settings form.
 */
class LarkmIntegrationSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'larkm_integration_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'larkm_integration.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('larkm_integration.settings');

    $form['larkm_integration_larkm_hostname'] = [
      '#type' => 'textfield',
      '#maxlength' => 256,
      '#title' => $this->t('larkm hostname'),
      '#description' => $this->t('Fully qualifed hostname (including "https" and any ports) where larmk is running.'),
      '#default_value' => $config->get('larkm_integration_larkm_hostname'),
    ];
    $form['larkm_integration_naan'] = [
      '#type' => 'textfield',
      '#maxlength' => 10,
      '#title' => $this->t('NAAN'),
      '#description' => $this->t("Your institutino's NAAN."),
      '#default_value' => $config->get('larkm_integration_naan'),
    ];
    $form['larkm_integration_shoulder'] = [
      '#type' => 'textfield',
      '#maxlength' => 10,
      '#title' => $this->t('Shoulder'),
      '#description' => $this->t("The shoulder to use in the ARKs."),
      '#default_value' => $config->get('larkm_integration_shoulder'),
    ];
    $form['larkm_integration_ark_fieldname'] = [
      '#type' => 'textfield',
      '#maxlength' => 256,
      '#title' => $this->t('ARK fieldname'),
      '#description' => $this->t('Machine name of the Drupal field where ARKs are to be stored.'),
      '#default_value' => $config->get('larkm_integration_ark_fieldname'),
    ];
    // For now, we're only interested in nodes.
    $bundle_info = \Drupal::service('entity_type.bundle.info')->getBundleInfo('node');
    $options = [];
    foreach ($bundle_info as $name => $details) {
      $options[$name] = $details['label'];
    }
    $form['larkm_integration_bundles'] = [
      // '#weight' => -10,
      '#type' => 'checkboxes',
      '#options' => $options,
      '#default_value' => $config->get('larkm_integration_bundles'),
      '#description' => $this->t('Mint ARKs for the checked content types.'),
      '#title' => $this->t('Content types'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('larkm_integration.settings')
      ->set('larkm_integration_larkm_hostname', $form_state->getValue('larkm_integration_larkm_hostname'))
      ->set('larkm_integration_naan', $form_state->getValue('larkm_integration_naan'))
      ->set('larkm_integration_shoulder', $form_state->getValue('larkm_integration_shoulder'))
      ->set('larkm_integration_ark_fieldname', $form_state->getValue('larkm_integration_ark_fieldname'))
      ->set('larkm_integration_bundles', $form_state->getValue('larkm_integration_bundles'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
