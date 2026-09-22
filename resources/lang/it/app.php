<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'welcome' => 'Benvenuto!',
    ],
    'sidebar' => [
        'dashboard'        => 'Pannello di Controllo',
        'users_management' => 'Gestione Utenti',
        'users'            => 'Utenti',
        'roles'            => 'Ruoli',
        'permissions'      => 'Permessi',
        'welcome_page'     => 'Pagina di Benvenuto',
    ],
    'permissions' => [
        'id'           => '#',
        'name'         => 'Nome',
        'guard'        => 'Guard',
        'created'      => 'Creato',
        'create_new'   => 'Crea Nuovo Permesso',
        'update_title' => 'Modifica Permesso: #:id',
        'save'         => 'Salva',
    ],
    'roles' => [
        'id'                     => '#',
        'name'                   => 'Nome',
        'created'                => 'Creato',
        'create_new'             => 'Crea Nuovo Ruolo',
        'update_title'           => 'Modifica Ruolo: #:id',
        'save'                   => 'Salva',
        'cancel'                 => 'Annulla',
        'search'                 => 'Cerca',
        'permissions'            => 'Permessi',
        'no_permissions'         => 'Nessun permesso disponibile',
        'no_records'             => 'Nessun record trovato',
        'manage_permissions'     => 'Gestisci Permessi del Ruolo: :name',
        'select_all_permissions' => 'Seleziona tutti i permessi',
        'permissions_updated'    => 'Permessi aggiornati con successo',
    ],
    'users' => [
        'id'               => '#',
        'name'             => 'Nome utente',
        'first_name'       => 'Nome',
        'last_name'        => 'Cognome',
        'email'            => 'E-mail',
        'roles'            => 'Ruoli',
        'created'          => 'Creato',
        'password'         => 'Password',
        'confirm_password' => 'Conferma Password',
        'password_hint'    => 'La password verrà aggiornata solo se inserisci un valore in questo campo',
        'create_new'       => 'Crea Nuovo Utente',
        'update_title'     => 'Modifica Utente: #:id',
        'save'             => 'Salva',
    ],
];
