<?php

namespace Drupal\forum_one_challenge\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with current user, last login time and link to user profile.
 *
 * @Block(
 *   id = "forum_one_block",
 *   admin_label = @Translation("Forum One block"),
 * )
 */
class ForumOneBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = \Drupal::currentUser();
    $username = $user->getUsername();
    $login_time = $user->getLastAccessedTime();
    $login_time_formatted = date('F j, Y g:i a', $login_time);
    $user_id = $user->id();
    $time = time();
    $element = array(
        '#markup' => 'Hello ' . $username . '! <br> Your last login time was ' . $login_time_formatted . '. <br> <a href="/user/' . $user_id . '">Visit your profile</a>',
    );
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'authenticated user');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
  }
}