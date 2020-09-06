GitHub -> Telegram PHP pull request spamer
==========================================

# Setup

See [Bots: An introduction for developers](https://core.telegram.org/bots)

1.  ```bash
    git clone blahblah PullRequestBot
    ```
1.  ```bash
    composer install
    ```
1.  Receive ```Telegram secret``` from [BotFather](https://t.me/botfather)

1.  set up .env

    ```bash
    #Telegram
    TELEGRAM_SECRET=Telegram_secret
    TELEGRAM_HOOK_URL=https://**yourdomain**/telehook.php
    TELEGRAM_UID=-1 #Leave this for now

    #GitHub
    GITHUB_SECRET=github_secret
    ```

1.  Activate your bot

    ```bash
    $ php activatebot.php

    Hook registered. Now send any message to bot, he will reply your uid
    ```
    
    Get uid from bot and enter it in **TELEGRAM_UID** section of .env

1.  Go to your GitHub repository **Settings** -> **Webhooks** -> **Add webhook**

    Set up your **Payload URL** for ex. https://mydomain.com/githook.php

    Set Content type to **application/json**

    Set up your ```Github secret```

    Chose radio **Let me select individual events** and select **Pull requests**

    Click **AddWebhook**