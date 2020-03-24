<?php
//===================================\\
//           Copyright 2017          \\
//           LIMAS Projects          \\
// Database supports for transaction \\
//===================================\\
namespace LIMAS\Database

{
    require_once './../config.php';
    require_once 'database.php';
    use LIMAS\Database\XAVIER as DB;
    use PDO;
    use Exception;

    class Transaction extends DB
    {
        public static function savetransaction($memberid, $userid, $returndate, array $books)
        {
            try {
                if (parent::$link === null) {
                    throw new Exception("No open connection");
                }
                $query['transaction']       = 'INSERT INTO transaksi (idanggota, tglpinjam, idpengguna, totdenda)
                                               VALUES (:memberid, :returndate, :userid, 0)';
                $query['transactiondetail'] = 'INSERT INTO detiltransaksi
                                               (idtransaksi, idbuku, tglharuskembali, tglpengembalian, denda) VALUES
                                               (:transactionid, :bookid, :duedate, NULL, 0)';
                $query['books']             = 'UPDATE buku SET jumlah=jumlah-1 WHERE id=:bookid';
                parent::$link->beginTransaction();
                foreach ($query as $stmt_name => &$sql_command) {
                    $stmt[$stmt_name] = parent::$link->prepare($sql_command);
                }
                $returndates = date('Y-m-d H:i:s', strtotime('+'.$returndate.' day'));
                $stmt['transaction']->execute(array(
                    ':memberid' => $memberid,
                    ':userid' => $userid,
                    ':returndate' => date("Y-m-d H:i:s")
                ));
                $transactionid = parent::$link->lastInsertId();
                $stmt['transactiondetail']->bindValue(':transactionid', $transactionid, PDO::PARAM_INT);
                $stmt['transactiondetail']->bindValue(':duedate', $returndates, PDO::PARAM_STR);
                foreach ($books as $id) {
                    $stmt['transactiondetail']->bindValue(':bookid', $id, PDO::PARAM_INT);
                    $stmt['books']->bindValue(':bookid', $id, PDO::PARAM_INT);
                    $stmt['transactiondetail']->execute();
                    $stmt['books']->execute();
                }
                parent::$link->commit();
            } catch (PDOException $e) {
                //parent::$link->rollback();
                //echo $e->getMessage();
            }
        }

        public function savereturn($memberid, $borrowdate, array $books)
        {
            try {
                if (parent::$link === null) {
                    throw new Exception("No open connection");
                }
                $query['transaction'] = 'UPDATE transaksi SET totdenda=:totdenda WHERE idanggota=:memberid AND tglpinjam=:borrowdate';
                $query['transactiondetail'] = 'UPDATE detiltransaksi SET tglpengembalian=:returndate WHERE idbuku=:bookid';
                $query['books'] = 'UPDATE buku SET jumlah=jumlah+1 WHERE id=:id';
                parent::$link->beginTransaction();
                foreach ($query as $stmt_name => &$sql_command) {
                    $stmt[$stmt_name] = parent::$link->prepare($sql_command);
                }
                $returndates = date('Y-m-d H:i:s');
                $stmt['transaction']->execute(array(':totdenda' => '0', ':memberid' => $memberid, ':borrowdate' => $borrowdate));
                $stmt['transactiondetail']->bindValue(':returndate', $returndates, PDO::PARAM_STR);
                foreach ($books as $id) {
                    $stmt['transactiondetail']->bindValue(':bookid', $id, PDO::PARAM_INT);
                    $stmt['books']->bindValue(':id', $id, PDO::PARAM_INT);
                    $stmt['transactiondetail']->execute();
                    $stmt['books']->execute();
                }
                parent::$link->commit();
            } catch (PDOException $e) {
                //
            }
        }
    }
}
