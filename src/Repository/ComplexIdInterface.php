<?php

/**
 * ComplexIdInterface.php
 * Mikro\Repository\ComplexIdInterface
 *
 * PHP version 7.4
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Repository;

/**
 * Interfaccia di definizione di chiavi identificative composte
 *
 * @category  Interface
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
interface ComplexIdInterface
{
    /**
     * Recupero array associativo key => value di chiavi identificative
     *
     * Ipotizziamo di avere 4 tabelle:
     *
     * # user
     * |-----------|----------------------|
     * | Proprietà | Descrizione          |
     * |-----------|----------------------|
     * | id        | Id utente            |
     * | name      | Nome                 |
     * | surname   | Cognome              |
     * | email     | Indirizzo e-mail     |
     * | role_id   | Identificativo ruolo |
     * |-----------|----------------------|
     *
     *
     * # role
     * |-----------|--------------|
     * | Proprietà | Tipo         |
     * |-----------|--------------|
     * | id        | Id Ruolo     |
     * | name      | Nome         |
     * |-----------|--------------|
     *
     *
     * # media
     * |-----------|--------------|
     * | Proprietà | Tipo         |
     * |-----------|--------------|
     * | id        | Id media     |
     * | caption   | Didascalia   |
     * | name      | Nome         |
     * |-----------|--------------|
     *
     *
     * # avatar
     * |-----------|--------------|
     * | Proprietà | Tipo         |
     * |-----------|--------------|
     * | user_id   | Id utente    |
     * | media_id  | Id media     |
     * |-----------|--------------|
     *
     * E un entità Utente che si presenta così:
     * {
     *   "id": 1,
     *   "name": "Federico",
     *   "surname": "Maffucci",
     *   "email": "f.maffucci@mail.com",
     *   "role": {
     *      "id": 12,
     *      "name": "Standard user"
     *   },
     *   "avatar": {
     *      "id": 1291,
     *      "caption": "Bella la vita",
     *      "name":  "archivio/media/immagini/12398193_123123jasd.jpg"
     *   }
     * }
     *
     * Per erogare in modo "strutturato" l'entità è necessario in primis costruire una query
     * di JOIN corretta come la seguente:
     *
     * SELECT DISTINCT
     *   `user`.*
     * FROM
     *   `user`
     * INNER JOIN `role`
     *   ON `role`.`id` = `user`.`role_id`
     * LEFT JOIN `avatar`
     *   ON `avatar`.`user_id` = `user`.`id`
     * LEFT JOIN `media`
     *   ON `media`.`media_id` = `avatar`.`media_id`
     *
     * Dopo di che in fase di Fetch e assegnazione ad entità è necessario
     * recuperare le entità da altri repository. Il risultato della query potrebbe essere questo:
     *
     * $result = [
     *   "id" => 1,
     *   "name" => "Federico",
     *   "surname" => "Maffucci",
     *   "email" => "f.maffucci@mail.com",
     *   "role_id" => 12
     * ];
     *
     * L'assegnazione all'entità richiede ancora 2 entità: ruolo e avatar se presente.
     *
     * Recupero del ruolo:
     *
     * $role = RepositoryFactory::create('role')->getById($result['role_id']);
     *
     *
     * Recupero dell'avatar ( Attraverso il mteodo personalizzato per esempio )
     *
     * $avatar = RepositoryFactory::create('avatar')->getByUserId($result['id']);
     *
     * A questo punto si può costruire l'entità definitiva.
     *
     * $user = new User();
     * $user->setId($result['id']);
     * $user->setName($result['name']);
     * $user->setSurname($result['surname']);
     * $user->setEmail($result['email']);
     * $user->setRole($role);
     * if (!is_null($vatar))
     *   $user->setAvatar($avatar);
     *
     * Ma cosa succede quando è necessario eliminare un avatar?
     *
     * Per eliminare una riga dalla tabella vatar è necessario dichiarare la complexId di riferimento.
     *
     * Per esempio una query corretta per l'eliminazione di una riga dalla tabella avatar potrebbe essere:
     *
     * DELETE FROM `avatar` WHERE `user_id` =  :user_id AND `media_id` = :media_id;
     *
     * Questa query può essere eseguita in modo automatico passando una ComplexIdInterface al metodo deleteById()
     * del complexIdRepository di riferimento.
     *
     * $avatarComplexId = new AvatarComplexId(12, 29);
     *
     * print_r($avatarComplexId->getIds());
     *
     * output:
     * [
     *   "user_id" => 12,
     *   "media_id" => 29
     * ]
     *
     * @return array
     */
    public function getIds(): array;
}
