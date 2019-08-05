<?php

class QueryBuild
{
    private $connection;
    private $query;
    private $host;
    private $dbname;
    private $user;
    private $userpw;

    public function __construct(String $host, String $dbname, String $user, String $userpw)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->userpw = $userpw;
    }

    public function connect()
    {
        try {
            $this->connection = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname,
                $this->user,
                $this->userpw
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function setQuery(String $query)
    {
        $this->query = $query;
    }

    // METODA ZA DOBIJANJE VISE PODATAKA IZ BAZE

    public function fetchMulti(...$binds)
    {
        $stmt = $this->connection->prepare($this->query);

        //PROVERAVA DA LI JE NIZ $binds PRAZAN IZ PARAMETRA 
        if (!is_null($binds)) {
            $queryBinds = [];
            $explodedQuery = explode(' ', $this->query);

            $abc = array_merge(range('A', 'Z'), range('a', 'z'));
            $abc[] = ':';
            $abc[] = '_';

            foreach ($explodedQuery as $elem) {

                if (strpos($elem, ':') !== false) {
                    $pos = strpos($elem, ":");
                    $bind = "";

                    while (in_array($elem[$pos], $abc)) {
                        $bind .= $elem[$pos];
                        $pos++;

                        if ($pos > (strlen($elem) - 1)) {
                            break;
                        }
                    }
                    $queryBinds[] = $bind;
                }
            }

            //ZA SVAKI BIND SA DVOTACKOM IZ QUERYJA BINDUJE VREDNOST IZ NIZA $query PARAMETRA
            if (count($queryBinds) === count($binds)) {
                for ($i = 0; $i < count($queryBinds); $i++) {
                    $stmt->bindParam($queryBinds[$i], $binds[$i]);
                }
            }

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt->fetchAll();
        }


        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetchAll();
    }

    // METODA ZA DOBIJANJE JEDNOG PODATAKA IZ BAZE
    //PRINCIP JE ISTI KAO U fetchMulti METODI ALI VRACA SAMO JEDAN PODATAK
    public function fetchSingle(...$binds)
    {
        $stmt = $this->connection->prepare($this->query);

        if (!is_null($binds)) {
            $queryBinds = [];
            $explodedQuery = explode(' ', $this->query);

            $abc = array_merge(range('A', 'Z'), range('a', 'z'));
            $abc[] = ':';
            $abc[] = '_';

            foreach ($explodedQuery as $elem) {

                if (strpos($elem, ':') !== false) {
                    $pos = strpos($elem, ":");
                    $bind = "";

                    while (in_array($elem[$pos], $abc)) {
                        $bind .= $elem[$pos];
                        $pos++;

                        if ($pos > (strlen($elem) - 1)) {
                            break;
                        }
                    }
                    $queryBinds[] = $bind;
                }
            }

            if (count($queryBinds) === count($binds)) {
                for ($i = 0; $i < count($queryBinds); $i++) {
                    $stmt->bindParam($queryBinds[$i], $binds[$i]);
                }
            }

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            return $stmt->fetch();
        }


        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        return $stmt->fetch();
    }

    public function execQuery(...$binds)
    {
        $stmt = $this->connection->prepare($this->query);

        if (!is_null($binds)) {
            $queryBinds = [];
            $explodedQuery = explode(' ', $this->query);

            $abc = array_merge(range('A', 'Z'), range('a', 'z'));
            $abc[] = ':';
            $abc[] = '_';

            foreach ($explodedQuery as $elem) {

                if (strpos($elem, ':') !== false) {
                    $pos = strpos($elem, ":");
                    $bind = "";

                    while (in_array($elem[$pos], $abc)) {
                        $bind .= $elem[$pos];
                        $pos++;

                        if ($pos > (strlen($elem) - 1)) {
                            break;
                        }
                    }
                    $queryBinds[] = $bind;
                }
            }

            if (count($queryBinds) === count($binds)) {
                for ($i = 0; $i < count($queryBinds); $i++) {
                    $stmt->bindParam($queryBinds[$i], $binds[$i]);
                }
            }

            $stmt->execute();
            return;
        }

        $stmt->execute();
    }
}

$getData = new QueryBuild('localhost', 'blog', 'arsen', 'arsenroot');
$getData->connect();
