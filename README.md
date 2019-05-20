<p align="center"><img src="https://user-images.githubusercontent.com/24509741/57247411-112eac00-7040-11e9-876a-1d65a4973ad5.png"></p>
<h1 align="center">heyLucy</h1>


HeyLucy è un semplicissimo ma potentissimo bot telegram in php. Permette di creare un bot in soli 10 minuti.

- E' composto da solamente 4 files.
- altamente personalizzabile
- usabile sia in singola chat che nei gruppi.
- Settaggio comandi separati per singola chat e group.


| filename      |  Description    |
|---------------|-----------------|
| bot.php       | Qui va tutta la logica del tuo bot insieme a le stringhe di configurazione|
| heyLucy.php   |	heyLucy core class |
| register.php  |   register webhook for your bot |
| webhook.php   |   webhook che viene richiamato dal server telegram all'arrivo di un messaggio |



## Prerequisites

What things you need to install the software:
- 1 webserver with https protocol
- Telegram for test :D


## Installation

Copia i 4 file sul una directory del webserver in modo che sia disponibile su internet.

installazione fatta :D

## Configurazione
edita il file **bot.php** e aggiungi le tue apikey, quelle create tramite botfather (tutorial creazione bot e api)

```php
var $bot_token = 'your_token_here';
var $webhook_url = 'link_to_webhook_file';
```
example:
```php
var $bot_token = '71872347:AAEsX6n2sH9ZZeWaa23WV1oifLeRUKQRDJU';
var $webhook_url = 'www.example.com/mybot/webhook.php';
```

## Registra il webhook
Apri il tuo browser e richiama il file register.php che è sul tuo server.
> www.example.com/mybot/register.php

il bot è funzionante! scrivigli un messaggio

## Creazione dei comandi personalizzati




## Creazione del bot telegram tramite botfather


## Usage


## Utility
#### Git Alert (git_alert.php)
Puoi settare il tuo repository git per notificare i push in questa maniera:

![image](https://user-images.githubusercontent.com/24509741/58053010-a197e100-7b56-11e9-9dc0-a0ecdc55e6e2.png)

l'unico parametro da passare è il chatid dove vuoi che notifica. (puoi saperlo eseguendo /chatid nel tuo bot)

riceverai un messaggio come questo:
![image](https://user-images.githubusercontent.com/24509741/58053208-23880a00-7b57-11e9-8fe3-6fb9f2463d5c.png)

#### Resend (resend.php)

#### Send (send.php)
Questo file serve per poter inviare messaggi da shell o in uno script, ad esempio uno script nel crontab.

```shell
php send.php chatid message
```


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[GPL3](https://choosealicense.com/licenses/gpl-3.0/)
