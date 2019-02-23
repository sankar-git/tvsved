============================send to this end========
<?php
if ($testmode)
{
	$url = ‘http://203.114.240.77/paynetz/epi/fts';// test bed URL
	$port = 80;
	$atom_prod_id = “TEST”;
}
else
{
	$url = ‘https://payment.atomtech.in/paynetz/epi/fts';//live URL
	$port = 443;
	$atom_prod_id = “TEST”;
}

// code to generate token
$param = “&login=”.$userid.”&pass=”.$password.”&ttype=NBFundTransfer&prodid=”.$atom_prod_id.”&amt=”.$amount.”&txncurr=INR&txnscamt=0&clientcode=”.$clientcode.”&txnid=”.$invoiceid.”&date=”.$today.”&custacc=12345″;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_PORT , $port);
curl_setopt($ch, CURLOPT_SSLVERSION,3);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
$returnData = curl_exec($ch);

// Check if any error occured
if(curl_errno($ch))
{
	echo ‘Curl error: ‘ . curl_error($ch);
}
curl_close($ch);

$xmlObj = new SimpleXMLElement($returnData);
$final_url = $xmlObj->MERCHANT->RESPONSE->url;
// eof code to generate token
// code to generate form action
$param = “”;
$param .= “&ttype=NBFundTransfer”;
$param .= “&tempTxnId=”.$xmlObj->MERCHANT->RESPONSE->param[1];
$param .= “&token=”.$xmlObj->MERCHANT->RESPONSE->param[2];
$param .= “&txnStage=1″;
$url = $url.”?”.$param;
// eof code to generate form action
?>
============================send to this end========


<form action='<?php echo $url?>’ method=’post’>
<input type=’submit’ value=’Pay Now’ name=’btn_pay’ />
</form>
============================Success Page========

<?php
// log post data
$orgipn = ”;
foreach ($_POST as $key => $value)
{
	$orgipn .= (” . $key . ‘ => ‘ . $value . ‘
‘);
}
// eof log post data

if($_POST[‘f_code’]==”Ok”) // atom status
{
	$invoiceid = $_POST[‘mer_txn’];
	$amount = $_POST[‘amt’];
	$transid = $_POST[‘mmp_txn’];
	
	// add your transaction

}
?>

============================Success Page========