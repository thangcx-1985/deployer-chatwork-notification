# deployer-chatwork-notification
This repository contains chatwork recipes to integrate with deployer.

## Installing
```
composer require thangcx-1985/deployer-chatwork-notification
```

Include recipes in deploy.php file.

```php
require 'vendor/thangcx-1985/deployer-chatwork-notification/recipe/chatwork.php';
```

## Configuration

- `chatwork_api_token` – chatwork api token, **required** 
- `chatwork_room_id` – chatwork room ID, **required** 
- `chatwork_text` – notification message template, default:
  ```
  [info][title]Deployer on {{target}}[/title]{{user}} is deploying branch {{branch}} to {{target}} envirement[/info]
  ```
- `chatwork_success_text` – success template, default:
  ```
  [info][title]Deployer on {{target}}[/title]Deployment is successful[/info]
  ```
- `chatwork_failure_text` – failure template, default:
  ```
  [info][title]Deployer on {{target}}[/title]Deployment is failed[/info]
  ```
- `chatwork_rollback_text` – rollback template, default:
  ```
  [info][title]Deployer on {{target}}[/title]Deployment is rolling back[/info]
  ```
## Tasks

- `chatwork:notify` – send message to chatwork
- `chatwork:notify:success` – send success message to chatwork
- `chatwork:notify:failed` – send failed message to chatwork
- `chatwork:notify:rollback` – send rolling back message to chatwork

## Usage

If you want to notify only about beginning of deployment add this line only:

```php
before('deploy', 'chatwork:notify');
```

If you want to notify about successful end of deployment add this too:

```php
after('success', 'chatwork:notify:success');
```

## License
Licensed under the MIT license.