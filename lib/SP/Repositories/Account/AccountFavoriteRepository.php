<?php
/**
 * sysPass
 *
 * @author nuxsmin 
 * @link https://syspass.org
 * @copyright 2012-2018, Rubén Domínguez nuxsmin@$syspass.org
 *
 * This file is part of sysPass.
 *
 * sysPass is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * sysPass is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 *  along with sysPass.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace SP\Repositories\Account;

use SP\Repositories\Repository;
use SP\Storage\DbWrapper;
use SP\Storage\QueryData;

/**
 * Class AccountFavoriteRepository
 *
 * @package SP\Repositories\Account
 */
class AccountFavoriteRepository extends Repository
{
    /**
     * Obtener un array con los Ids de cuentas favoritas
     *
     * @param $id int El Id de usuario
     * @return array
     */
    public function getForUserId($id)
    {
        $queryData = new QueryData();
        $queryData->setQuery('SELECT accountId, userId FROM AccountToFavorite WHERE userId = ?');
        $queryData->addParam($id);
        $queryData->setUseKeyPair(true);

        return DbWrapper::getResultsArray($queryData, $this->db);
    }

    /**
     * Añadir una cuenta a la lista de favoritos
     *
     * @param $accountId int El Id de la cuenta
     * @param $userId    int El Id del usuario
     * @return bool
     * @throws \SP\Core\Exceptions\SPException
     */
    public function add($accountId, $userId)
    {
        $queryData = new QueryData();
        $queryData->setQuery('INSERT INTO AccountToFavorite SET accountId = ?, userId = ?');
        $queryData->addParam($accountId);
        $queryData->addParam($userId);
        $queryData->setOnErrorMessage(__u('Error al añadir favorito'));

        return DbWrapper::getQuery($queryData, $this->db);
    }

    /**
     * Eliminar una cuenta de la lista de favoritos
     *
     * @param $accountId int El Id de la cuenta
     * @param $userId    int El Id del usuario
     * @return int
     * @throws \SP\Core\Exceptions\ConstraintException
     * @throws \SP\Core\Exceptions\QueryException
     */
    public function delete($accountId, $userId)
    {
        $queryData = new QueryData();
        $queryData->setQuery('DELETE FROM AccountToFavorite WHERE accountId = ? AND userId = ?');
        $queryData->addParam($accountId);
        $queryData->addParam($userId);
        $queryData->setOnErrorMessage(__u('Error al eliminar favorito'));

        DbWrapper::getQuery($queryData, $this->db);

        return $this->db->getNumRows();
    }
}