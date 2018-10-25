<?php
// require_once __DIR__ . '/vendor/autoload.php';
use appName\Database\Database;

$db = new Database();
$customerTable;
if (!isset($customerTable)){
    $stmt = $db->getQuery("SELECT 
                                CUST_NAME as nameCustomer,
                                CUST_CITY as city,
                                CUST_COUNTRY as country,
                                OUTSTANDING_AMT as countAMT
                           FROM customer");
    $customerTable = '
    <table class="">
            <thead >
                <tr >
                    <td>Nom</td>
                    <td>Ville</td>
                    <td>Pays</td>
                    <td>Montant restant</td>
                </tr>
            </thead>';
    foreach ($stmt as $value) {
        $customerTable .= '<tbody>
                    <tr>
                        <td>'.$value->nameCustomer.'</td>
                        <td>'.$value->city.'</td>
                        <td>'.$value->country.'</td>
                        <td>'.$value->countAMT.'</td>
                    </tr>
                 </tbody>';
    }
    $customerTable .= '</table>';
}
// date('Y',strtotime($value->date))