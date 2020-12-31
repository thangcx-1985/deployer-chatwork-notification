<?php
/*
## Installing

<a href="https://slack.com/oauth/authorize?&client_id=113734341365.225973502034&scope=incoming-webhook"><img alt="Add to Slack" height="40" width="139" src="https://platform.slack-edge.com/img/add_to_slack.png" srcset="https://platform.slack-edge.com/img/add_to_slack.png 1x, https://platform.slack-edge.com/img/add_to_slack@2x.png 2x" /></a>

Require slack recipe in your `deploy.php` file:

```php
require 'contrib/slack.php';
```

Add hook on deploy:

```php
before('deploy', 'slack:notify');
```

## Configuration

- `slack_webhook` – slack incoming webhook url, **required**
  ```
  set('slack_webhook', 'https://hooks.slack.com/...');
  ```
- `slack_title` – the title of application, default `{{application}}`
- `slack_text` – notification message template, markdown supported
  ```
  set('slack_text', '_{{user}}_ deploying `{{branch}}` to *{{target}}*');
  ```
- `slack_success_text` – success template, default:
  ```
  set('slack_success_text', 'Deploy to *{{target}}* successful');
  ```
- `slack_failure_text` – failure template, default:
  ```
  set('slack_failure_text', 'Deploy to *{{target}}* failed');
  ```

- `slack_color` – color's attachment
- `slack_success_color` – success color's attachment
- `slack_failure_color` – failure color's attachment

## Usage

If you want to notify only about beginning of deployment add this line only:

```php
before('deploy', 'slack:notify');
```

If you want to notify about successful end of deployment add this too:

```php
after('deploy:success', 'slack:notify:success');
```

If you want to notify about failed deployment add this too:

```php
after('deploy:failed', 'slack:notify:failure');
```

 */
namespace Deployer;

use Deployer\Utility\Httpie;

// Chatwork
set('chatwork_base_url', 'https://api.chatwork.com/v2');

// Project title
set('chatwork_title', function () {
    return get('application', 'Project');
});

// Deploy message
set('chatwork_text', '_{{user}}_ deploying `{{branch}}` to *{{target}}*');
set('chatwork_success_text', 'Deploy to *{{target}}* successful');
set('chatwork_failure_text', 'Deploy to *{{target}}* failed');
set('chatwork_rollback_text', '_{{user}}_ rolled back changes on *{{target}}*');

// Task
desc('Notifying Chatwork');
task('chatwork:notify', function () {
    if (!get('chatwork_room_id', false) || !get('chatwork_api_token', false)) {
        return;
    }
    Httpie::post(get('chatwork_base_url') . '/rooms/' . get('chatwork_room_id') . '/messages')
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form(['body' => get('chatwork_text')])->send();
})
    ->once()
    ->shallow()
    ->hidden();

desc('Notifying Chatwork about deploy finish');
task('chatwork:notify:success', function () {
    if (!get('chatwork_room_id', false) || !get('chatwork_api_token', false)) {
        return;
    }
    Httpie::post(get('chatwork_base_url') . '/rooms/' . get('chatwork_room_id') . '/messages')
        ->header('X-ChatWorkToken: ' . get('chatwork_api_token'))
        ->form(['body' => get('chatwork_success_text')])->send();
})
    ->once()
    ->shallow()
    ->hidden();
