<?php

declare(strict_types=1);

return [
    'title' => 'Profilo',
    'tabs'  => [
        'profile'    => 'Profilo',
        'password'   => 'Password',
        'two_factor' => 'Autenticazione a Due Fattori',
    ],
    'information' => [
        'name'           => 'Nome utente',
        'first_name'     => 'Nome',
        'last_name'      => 'Cognome',
        'email'          => 'E-mail',
        'theme'          => 'Tema',
        'font'           => 'Carattere',
        'assigned_roles' => 'Ruoli Assegnati',
        'save'           => 'Salva',
    ],
    'themes' => [
        'teal'    => 'Verde Acqua',
        'emerald' => 'Smeraldo',
        'cyan'    => 'Ciano',
        'violet'  => 'Viola',
    ],
    'delete' => [
        'delete_profile'   => 'Elimina Profilo',
        'confirm_message'  => 'Sei sicuro di voler eliminare il tuo profilo? Questa azione non può essere annullata.',
        'current_password' => 'Password Attuale',
        'cancel'           => 'Annulla',
        'delete'           => 'Elimina',
    ],
    'password' => [
        'current_password' => 'Password Attuale',
        'new_password'     => 'Nuova Password',
        'confirm_password' => 'Conferma Password',
        'save'             => 'Salva',
    ],
    'recovery_codes' => [
        'title'       => 'Codici di Recupero',
        'description' => 'Conserva questi codici di recupero in un gestore di password sicuro. Possono essere usati per recuperare l\'accesso al tuo account se perdi il dispositivo di autenticazione.',
        'refresh'     => 'Rigenera Codici',
        'download'    => 'Scarica Codici',
        'close'       => 'Chiudi',
    ],
    'two_factor' => [
        'enabled_message'  => 'L\'autenticazione a due fattori è abilitata sul tuo account.',
        'pending_message'  => 'Scansiona il codice QR con la tua app di autenticazione, poi inserisci il codice a 6 cifre per completare l\'attivazione dell\'autenticazione a due fattori.',
        'description'      => 'Quando l\'autenticazione a due fattori è abilitata, durante l\'accesso ti verrà richiesto un token sicuro e casuale. Puoi recuperare questo token dall\'applicazione Google Authenticator sul tuo telefono.',
        'current_password' => 'Password Attuale',
        'show_codes'       => 'Mostra Codici di Recupero',
        'setup_key'        => 'Chiave di configurazione',
        'code'             => 'Codice di Autenticazione',
        'enable'           => 'Abilita',
        'disable'          => 'Disabilita',
        'confirm'          => 'Conferma',
        'cancel'           => 'Annulla',
        'invalid_code'     => 'Il codice di autenticazione a due fattori fornito non è valido.',
    ],
    'attributes' => [
        'name'             => 'nome utente',
        'first_name'       => 'nome',
        'last_name'        => 'cognome',
        'theme'            => 'tema',
        'font'             => 'carattere',
        'password'         => 'password',
        'current_password' => 'password attuale',
        'code'             => 'codice di autenticazione',
    ],
];
