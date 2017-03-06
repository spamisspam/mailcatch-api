<?php
/**
 * SpamIsSpam Mailcatch Support Library - mailcatch.spamisspam.com
 *
 * @copyright 2017, Brian Tafoya.
 * @package   SpamIsSpamMailcatch
 * @author    Brian Tafoya <brian@spamisspam.com>
 * @version   1.0
 * @license   MIT
 * @license   https://opensource.org/licenses/MIT The MIT License
 * @category  SpamIsSpamMailcatch_Support_Library
 * @link      http://mailcatch.spamisspam.com SpamIsSpam Mailcatch
 *
 * Copyright (c) 2017, Brian Tafoya
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Class SpamIsSpamMailcatch
 *
 * @package SpamIsSpam\Mailcatch
 */
class SpamIsSpamMailcatch
{
	/**
	 * @var string $uuid Unique ID last generated.
	 */
    static public $uuid;

    /**
     * uuid().
     * Generate a unique 32 character key.
     *
     * @method uuid()
     * @access public
     * @return string
     *
     * @author  Brian Tafoya <brian@spamisspam.com>
     * @version 1.0
     */
    static public function uuid() 
    {
        self::$uuid = md5(uniqid(rand() + MicroTime(), 1));
        return self::$uuid;
    }

    /**
     * getMessageResult($uuid).
     * Get message results for a given UUID.
     *
     * @method  getMessageResult($uuid)
     * @author  Brian Tafoya <brian@spamisspam.com>
     * @version 1.0
     * @access  public
     * @param   String $uuid Unique 32 character identifier.
     * @return  mixed
     */
    static public function getMessageResult($uuid) 
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://mailcatch.spamisspam.com/json?uuid=' . $uuid);
        $response = json_decode((string)$res->getBody(), true);

        return ($response && isset($response["message"]["uuid"]) ? $response["message"]["uuid"] : false);
    }

    /**
     * sendSMTPMessage($uuid, $from_email, $from_name).
     * Send an SMTP message directly to mailcatch.spamisspam.com.
     *
     * @method  sendSMTPMessage($uuid, $from_email, $from_name)
     * @author  Brian Tafoya <brian@spamisspam.com>
     * @version 1.0
     * @access  public
     * @param   String $uuid Unique 32 character identifier.
     * @param   String $fromEmail Sender Email
     * @param   String $fromName Sender Name
     * @return  boolean
     * @throws  phpmailerException Throws phpmailerException on mailer issues.
     * @throws  Exception Throws Exception on code issues.
     */
    static public function sendSMTPMessage($uuid, $fromEmail, $fromName) 
    {
        $catchMessage = "SpamIsSpam-Mailcatch-API:" . $uuid;
        $cleanFromEmail = filter_var($fromEmail, FILTER_SANITIZE_EMAIL);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = "mailcatch.spamisspam.com";
            $mail->SMTPAuth = false;
            $mail->Port = 10025;
            $mail->XMailer = "SpamIsSpam-Mailcatch-API";
            $mail->Helo = "api.spamisspam.com";
            $mail->Hostname = "api.spamisspam.com";

            $mail->From = $cleanFromEmail;
            $mail->FromName = $fromName;
            $mail->AddAddress($uuid . "@spamisspam.com", "SpamIsSpam-Mailcatch-API");
            $mail->WordWrap = 50;
            $mail->IsHTML(false);

            $mail->Subject = $catchMessage;
            $mail->Body = $catchMessage;

            $mail->addCustomHeader("X-AntiAbuse", "This is a solicited email for " . $catchMessage . ".");
            $mail->addCustomHeader("X-AntiAbuse", "mailcatch.spamisspam.com");

            return (boolean)($mail->Send() ? true : false);

        } catch (phpmailerException $e) {
            throw new Exception($e->errorMessage());
        } catch (Exception $e) {
            throw new Exception($e->errorMessage());
        }
    }
}
