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

            foreach ($explodedQuery as $elem) {
                if ($elem[0] === ':') {
                    $queryBinds[] = $elem;
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
        $stmt = $this->conn->getConnection->prepare($this->query);

        if (!is_null($binds)) {
            $queryBinds = [];
            $explodedQuery = explode(' ', $this->query);

            foreach ($explodedQuery as $elem) {
                if ($elem[0] === ':') {
                    $queryBinds[] = $elem;
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
}

$getData = new QueryBuild('localhost', 'blog', 'arsen', 'arsenroot');
$getData->connect();
$getData->setQuery('SELECT * FROM posts WHERE id = :id AND author = :author');
$posts = $getData->fetchMulti(8, 1);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <?php foreach ($posts as $p) { ?>
        <div>
            <?php echo $p['title'] . "<br>" . $p['body']; ?>
        </div>
    <?php } ?>
</body>

</html>