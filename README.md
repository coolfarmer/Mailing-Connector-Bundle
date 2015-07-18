Mailing Connector
==================

Ce component permet d'abstraire des outils de gestion de newsletter comme CampaignCommander, MailChimp, etc.


## Installation

If not using packagist, add the git repository to your composer file.

    #composer.json
    ...
    "repositories": [
        {
            "type": "vcs",
            "url":  "ssh://git@stash.bitbucket.lan:7999/components/mailing-connector.git"
        }
    ]
    ...

Add the require for the bundle in your composer file.

    # composer.json
    ...
    "require": {
        "coolfarmer/mailing-connector": "dev-master"
    }
    ...

Update your dependencies

    $composer.phar update coolfarmer/mailing-connector


## Example usage with CampaignCommander API

### Get CampaignCommander Manager

```php
$mailingManager = ManagerFactory::createCampaignCommander('login', 'password', 'api_key', 'server');
$mailingConnectorManager = new MailingConnectorManager($mailingManager);
```

### Subscribe a new member

```php
$member = $mailingConnectorManager->createNewMember('member@domain.com');
$member
    ->setFirstName('Roger')
    ->setLastName('Bruxelle');
$mailingConnectorManager->getMemberService()->subscribe($member);
```

You can add custom field pre-defined in your manager admin :

```php
$member->setEmvAdmin1('test');
```

### Unsubscribe a member

```php
$mailingConnectorManager->getMemberService()->unsubscribe('member@domain.com');
```

### Find a member by email

```php
$memberProfile = $mailingConnectorManager->getMemberService()->findByEmail('member@domain.com');
```

### Send a transactional message

```php
$transactionalEmail = new TransactionalEmail(templateId, 'member@domain.com');
$transactionalEmail
    ->addAttributes('firstname', 'Roger')
    ->addAttributes('lastName', 'Bruxelle')
    ->addOption('content', array(
            1 => 'Block content 1',
        ))
    ->addOption('random', 'abc123')
    ->addOption('encrypt', '123456');
    
$mailingConnectorManager->getNotificationService()->send($transactionalEmail);
```

### Subscribe a batch of member

```php
$memberFileImport = new MemberFileImport('BatchMemberTest.csv');
$memberFileImport->addOption('file', file_get_contents('/tmp/BatchMemberTest.csv'));

$mailingConnectorManager->getImportMemberService()->uploadFile($memberFileImport);
```

## Implementing your own manager

Take an example in `CampaignCommander` manager directory.
Create a new directory in `src/Coolfarmer/Component/MailingConnector/Manager/{YourManagerName}` and add a class `YourManagerNameManager.php`
who implement `Manager` interface.

Then implement every service for your manager (member, notification, etc.).