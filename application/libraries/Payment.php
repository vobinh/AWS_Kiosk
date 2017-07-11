<?php
/*********************************************************

* DO NOT REMOVE *

Project: PHP PayPal Class 1.0
Url: http://phpweby.com
Copyright: (C) 2009 Blagoj Janevski - bl@blagoj.com
Project Manager: Blagoj Janevski

For help, comments, feedback, discussion ... please join our
Webmaster forums - http://forums.phpweby.com

License------------------------------------------------:
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
End License----------------------------------------------

*********************************************************/

class Payment_Core
{
	public $cc_name;
    public $cc_number;
    public $cc_cvv;
    public $cc_month;
    public $cc_year;
    public $email;
    public $transaction_id;

    public function charge($billing) {
        //TESTING ACCOUNT
        //get from account API settings these are not valid keys, key_id, gateway_id or password
        $key = '4Iq0c2T1DR2hk0qNtpef4';
        $key_id = 231212;
        $gateway_id = 'AI2313-05';
        $endpoint = 'https://api.demo.globalgatewaye4.firstdata.com/transaction/v14';
        //$endpoint = 'https://api.globalgatewaye4.firstdata.com/transaction/v14';
        $password = 'yxxuem2u3956s7v01o27l2t0hj6gch50';

        $myorder = array(
            'gateway_id' => $gateway_id,
            'password' => $password,
            'transaction_type' => '00',
            'amount' => $this->amount,
            'cardholder_name' => $this->cc_name,
            'cc_number' => $this->cc_number,
            'cc_expiry' => str_pad(($this->cc_month + 1),2,'0',STR_PAD_LEFT) . (date('y') + intval($this->cc_year)), //format 0414
            'cvd_code' => $this->cc_cvv,
            'client_ip' => $_SERVER['REMOTE_ADDR'],
            'client_email' => $this->email,
            'zip_code' => $billing->zip,
            'address' => array(
                'address1' => $billing->address,
                'address2' => $billing->address2,
                'city' => $billing->city,
                'state' => $billing->state,
                'zip' => $billing->zip
            ),
        );
        
        $data_string = json_encode($myorder);
        
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL,$endpoint);
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_VERBOSE, 1);
        
        $content_digest = sha1($data_string);
        
        $current_time = gmdate('Y-m-dTH:i:s') . 'Z';
        $current_time = str_replace('GMT', 'T', $current_time);
        
        $code_string = "POST\napplication/json\n{$content_digest}\n{$current_time}\n/transaction/v14";
        $code = base64_encode(hash_hmac('sha1',$code_string,$key,true));
        
        $header_array = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
            'X-GGe4-Content-SHA1: '. $content_digest,
	    'X-GGe4-Date: ' . $current_time,
	    'Authorization: GGE4_API ' . $key_id . ':' . $code,
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array);
        $result = curl_exec ($ch);
        curl_close($ch);
        
        $result = json_decode($result);
        if ($result->transaction_approved == '0') {
            return array('success'=>false,'error'=>$result->bank_message);
	} else {
            $this->transaction_id = $result->transaction_tag;
            return array('success'=>true);
	}
    }


}
