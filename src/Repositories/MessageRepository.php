<?php

namespace Chat\Repositories;

class MessageRepository extends BaseRepository
{

    public function getTableName()
    {
        return 'message';
    }
    protected function findBy(array $fields = [],$sort=['id'=>'desc'])
    {
        $searchValues = [];

        $statement = "SELECT u.username as senderId ,m.message as message , m.createdAt as createdAt FROM {$this->table} m left join user u on m.senderId=u.id";

        if (!empty($fields)) {
            $statement .= ' where 1=1 ';
            foreach ($fields as $fieldName => $fieldValue) {
                $statement .= "AND $fieldName = ? ";
                $searchValues[] = $fieldValue;
            }
        }
        if(!empty($sort)){
            $statement .= ' order by  ';
            foreach ($sort as $key=>$value){

                $statement.="$key $value";
            }
        }

        $query = self::getDBInstance()->prepare($statement);
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $result=$query->execute($searchValues);

        if ($result) {
            return $query;
        } else {
            var_dump( $query->errorInfo());
            die;
        }

    }
}