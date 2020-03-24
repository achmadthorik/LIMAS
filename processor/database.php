<?php
//===================================\\
//           Copyright 2017          \\
//           LIMAS Project           \\
//===================================\\
namespace LIMAS\Database

{

    //require_once './guardian.php';
    use PDO;
    use Exception;

    class XAVIER
    {
        //******** SERVER SETTINGS ********\\
        private static $dbprovider = "mysql";
        private static $serverhost = "localhost";
        private static $username   = "root";
        private static $password   = "";
        private static $database   = "limax";
        //*********************************\\

        //********* QUERY SUPPORT *********\\
        protected static $link = null;
        //*********************************\\

        //******* Connect to server *******\\
        public static function connect($returns = null)
        {
            try {
                $dbprovider = self::$dbprovider;
                $serverhost = self::$serverhost;
                $database   = self::$database;

                if (self::$link !== null) {
                    if ($returns === "return") {
                        return ("Connection already established");
                    }
                }
                self::$link = new PDO(
                    "{$dbprovider}:host={$serverhost};dbname={$database}",
                    self::$username,
                    self::$password
                );

                self::$link->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                if ($returns === "return") {
                    return "Connected successfully";
                }
            } catch (PDOException $e) {
                //throw new Exception($e);
            }
        }
        //*********************************\\

        //***** Disconnect from server *****\\
        public static function disconnect($returns = null)
        {
            if (self::$link !== null) {
                self::$link = null;
                if ($returns === "return") {
                    return "Disconnected successfully";
                }
            } else {
                if ($returns === "return") {
                    return "Already disconnected";
                }
            }
        }
        //**********************************\\


        /************* SELECT FUNCTION *************/
        public static function select($query, $parameter, $mode = "FETCH_BOTH", $returns = null)
        {
            try {
                if (self::$link === null) {
                    throw new Exception("No open connection");
                }

                self::$link->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
                $stmt = self::$link->prepare($query);
                if (isset($parameter)) {
                    $stmt->execute($parameter);
                } else {
                    $stmt->execute();
                }

                switch ($mode) {
                    case 'FETCH_ASSOC':
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        break;

                    case 'FETCH_NUM':
                        $stmt->setFetchMode(PDO::FETCH_NUM);
                        break;

                    case 'FETCH_BOTH':
                        $stmt->setFetchMode(PDO::FETCH_BOTH);
                        break;

                    default:
                        throw new Exception("Invalid argument for mode: $mode");
                        break;
                }
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                //throw new Exception($e);
            }
        }
        /*******************************************/

        /************* INSERT FUNCTION *************/
        public static function insert($query, $parameter, $mode = "SINGLE", $returns = null)
        {
            try {
                if (self::$link === null) {
                    throw new Exception("No open connection");
                }

                switch ($mode) {
                    case 'MULTIPLE_MQ':
                        try {
                            if (sizeof($query) !== sizeof($parameter)) {
                                throw new Exception("Invalid argument for query or parameter");
                            }
                            self::$link->beginTransaction();
                            if (isset($parameter)) {
                                foreach ($query as $pkey => $value) {
                                    if (sizeof($value) > 1) {
                                        $stmt = self::$link->prepare($value);
                                        foreach ($value as $key => $value) {
                                            $stmt->execute($parameter[$pkey]);
                                        }
                                    } else {
                                        $stmt = self::$link->prepare($value);
                                        $stmt->execute($parameter[$key]);
                                    }
                                }
                            } else {
                                foreach ($query as $key => $value) {
                                    $stmt = self::$link->prepare($value);
                                    $stmt->execute();
                                }
                            }
                            self::$link->commit();
                            if ($returns === "return") {
                                return "New records created successfully";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'MULTIPLE_SQ':
                        try {
                            self::$link->beginTransaction();
                            $stmt = self::$link->prepare($query);
                            foreach ($parameter as $key => $value) {
                                $stmt->execute($value);
                            }
                            self::$link->commit();
                            if ($returns === "return") {
                                return "New records created successfully";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'SINGLE':
                        $stmt = self::$link->prepare($query);
                        if (isset($parameter)) {
                            $stmt->execute($parameter);
                        } else {
                            $stmt->execute();
                        }
                        if ($returns === "return") {
                            return "New record created successfully";
                        }
                        break;

                    default:
                        throw new Exception("Invalid argument for mode: $mode");
                        break;
                }
            } catch (PDOException $e) {
                //self::$link->rollback();
                //throw new Exception($e);
            }
        }
        /*******************************************/

        /************* UPDATE FUNCTION *************/
        public static function update($query, $parameter, $mode = "SINGLE", $returns = null)
        {
            try {
                if (self::$link === null) {
                    throw new Exception("No open connection");
                }

                switch ($mode) {
                    case 'MULTIPLE_MQ':
                        try {
                            if (sizeof($query) !== sizeof($parameter)) {
                                throw new Exception("Invalid argument for query or parameter");
                            }
                            self::$link->beginTransaction();
                            if (isset($parameter)) {
                                foreach ($query as $pkey => $value) {
                                    if (sizeof($value) > 1) {
                                        $stmt = self::$link->prepare($value);
                                        foreach ($value as $key => $value) {
                                            $stmt->execute($parameter[$pkey]);
                                        }
                                    } else {
                                        $stmt = self::$link->prepare($value);
                                        $stmt->execute($parameter[$key]);
                                    }
                                }
                            } else {
                                foreach ($query as $key => $value) {
                                    $stmt = self::$link->prepare($value);
                                    $stmt->execute();
                                }
                            }
                            self::$link->commit();
                            if ($returns === "return") {
                                return "Records successfully updated";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'MULTIPLE_SQ':
                        try {
                            self::$link->beginTransaction();
                            $stmt = self::$link->prepare($query);
                            foreach ($parameter as $key => $value) {
                                $stmt->execute($value);
                            }
                            self::$link->commit();
                            if ($returns === "return") {
                                return "Records successfully updated";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'SINGLE':
                        $stmt = self::$link->prepare($query);
                        if (isset($parameter)) {
                            $stmt->execute($parameter);
                        } else {
                            $stmt->execute();
                        }
                        if ($returns === "return") {
                            return "Record successfully updated";
                        }
                        break;

                    default:
                        throw new Exception("Invalid argument for mode: $mode");
                        break;
                }
            } catch (PDOException $e) {
                //self::$link->rollback();
                //throw new Exception($e);
            }
        }
        /*******************************************/

        /************* DELETE FUNCTION *************/
        public static function delete($query, $parameter, $mode = "SINGLE", $returns = null)
        {
            try {
                if (self::$link === null) {
                    throw new Exception("No open connection");
                }

                switch ($mode) {
                    case 'MULTIPLE_MQ':
                        try {
                            if (sizeof($query) !== sizeof($parameter)) {
                                throw new Exception("Invalid argument for query or parameter");
                            }
                            self::$link->beginTransaction();
                            if (isset($parameter)) {
                                foreach ($query as $pkey => $value) {
                                    if (sizeof($value) > 1) {
                                        $stmt = self::$link->prepare($value);
                                        foreach ($value as $key => $value) {
                                            $stmt->execute($parameter[$pkey]);
                                        }
                                    } else {
                                        $stmt = self::$link->prepare($value);
                                        $stmt->execute($parameter[$key]);
                                    }
                                }
                            } else {
                                foreach ($query as $key => $value) {
                                    $stmt = self::$link->prepare($value);
                                    $stmt->execute();
                                }
                            }

                            self::$link->commit();
                            if ($returns === "return") {
                                return "Records successfully deleted";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'MULTIPLE_SQ':
                        try {
                            self::$link->beginTransaction();
                            $stmt = self::$link->prepare($query);
                            foreach ($parameter as $key => $value) {
                                $stmt->execute($value);
                            }
                            self::$link->commit();
                            if ($returns === "return") {
                                return "Records successfully deleted";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'SINGLE':
                        $stmt = self::$link->prepare($query);
                        if (isset($parameter)) {
                            $stmt->execute($parameter);
                        } else {
                            $stmt->execute();
                        }
                        if ($returns === "return") {
                            return "Record successfully deleted";
                        }
                        break;

                    default:
                        throw new Exception("Invalid argument for mode: $mode");
                        break;
                }
            } catch (PDOException $e) {
                //self::$link->rollback();
                //throw new Exception($e);
            }
        }
        /*******************************************/

        /************** MIX FUNCTION ***************/
        public static function mix($query, $parameter, $mode, $returns = null)
        {
            try {
                if (self::$link === null) {
                    throw new Exception("No open connection");
                }

                switch ($mode) {
                    case 'MULTIPLE_MQ':
                        try {
                            if (sizeof($query) !== sizeof($parameter)) {
                                throw new Exception("Invalid argument for query or parameter");
                            }
                            self::$link->beginTransaction();
                            if (isset($parameter)) {
                                foreach ($query as $pkey => $value) {
                                    if (sizeof($value) > 1) {
                                        $stmt = self::$link->prepare($value);
                                        foreach ($value as $key => $value) {
                                            $stmt->execute($parameter[$pkey]);
                                        }
                                    } else {
                                        $stmt = self::$link->prepare($value);
                                        $stmt->execute($parameter[$key]);
                                    }
                                }
                            } else {
                                foreach ($query as $key => $value) {
                                    $stmt = self::$link->prepare($value);
                                    $stmt->execute();
                                }
                            }

                            self::$link->commit();
                            if ($returns === "return") {
                                return "MIX Function sucessfully executed";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    case 'MULTIPLE_SQ':
                        try {
                            self::$link->beginTransaction();
                            $stmt = self::$link->prepare($query);
                            foreach ($parameter as $key => $value) {
                                $stmt->execute($value);
                            }
                            self::$link->commit();
                            if ($returns === "return") {
                                return "MIX Function sucessfully executed";
                            }
                        } catch (PDOException $e) {
                            self::$link->rollback();
                            throw new Exception($e);
                        }
                        break;

                    default:
                        throw new Exception("Invalid argument for mode: $mode");
                        break;
                }
            } catch (PDOException $e) {
                //self::$link->rollback();
                //throw new Exception($e);
            }
        }
        /*******************************************/
    }
}


/*class oop
{
    public static $val;

    public function add($var)
    {
        self::$val+=$var;
        return $this;
    }

    public function sub($var)
    {
        static::$val-=$var;
        return $this;
    }

    public static function out()
    {
        return static::$val;
    }

    public static function init($var)
    {
        static::$val=$var;
        return new static;
    }
}

echo oop::init(5)->add(2)->out();*/
