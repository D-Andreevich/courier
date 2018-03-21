<?php
/* alpha sms*/

namespace App\Components\Sms\Alpha;

use App\Components\Sms\Interfaces\SmsHandler;
use App\Events\Hidden\SendSms;
use Illuminate\Support\Facades\Log;

/**

 */
class AlphaHandler implements SmsHandler
{
    /**
     * @var string
     */
    public $version = '1.9';
    /**
     * @var string
     */
    protected $mode = 'HTTPS'; //HTTP or HTTPS
    /**
     * @var string
     */
    protected $server = '://alphasms.com.ua/api/http.php';
    /**
     * @var array
     */
    protected $errors = [];
    /**
     * @var array
     */
    protected $lastResponse = [];

    /**
     * @var string API key - copy it from your account
     */
    protected $apiKey;
    /**
     * @var string
     */
    protected $caption;
    /**
     * @var mixed
     */
    protected $login;
    /**
     * @var mixed
     */
    protected $password;
    /**
     * @var int
     */
    protected $sendDt = 0;
    /**
     * @var int
     */
    protected $wap = 0;
    /**
     * @var int
     */
    protected $flash = 0;
    /**
     * @var bool
     */
    private $emulation = false;
    /**
     * @var array
     */
    private $data = [];

    /**
     * AlphaHandler constructor.
     */
    public function __construct()
    {
        $config = config('sms');
        if (isset($config['emulation']) && (bool)$config['emulation']) {
            $this->emulation = (bool)$config['emulation'];
        }
        $this->caption = $config['caption'];
        $this->key = $config['apiKey'];
        $this->login = $config['login'];
        $this->password = $config['password'];
    }

    /**
     * $sms->send('prime', 380670000001, 'text');
     *
     * @param $from // — адрес отправителя;
     * @param $to // — номер телефона получателя сообщения;
     * @param $message // — текст сообщения;
     */
    public function send($from, $to, $message)
    {
        if (!$this->sendDt) {
            $this->sendDt = date('Y-m-d H:i:s');
        }
        $d = is_numeric($this->sendDt) ? $this->sendDt : strtotime($this->sendDt);

        if ($this->emulation) {
            return $this->emulationSend($to, $message, $d);
        }
        if (!is_null($from) && trim($from) != false) {
            $this->caption = $from;
        }
        $this->setData([
            'from' => $this->caption,
            'to' => (int)(380 . $to),
            'message' => (string)$message,
            'ask_date' => date(\DateTime::ISO8601, $d),
            'wap' => $this->wap,
            'flash' => $this->flash,
            'class_version' => $this->version
        ]);
        $result = $this->execute('send', $this->getData());

        if (count(@$result['errors'])) {
            Log::error('SmsSendError: ' . implode(', ', $result['errors']));

            return false;
        }

        return true;
    }

    private function emulationSend(int $to, string $message, $d)
    {
        $this->setData([
            'from' => 'emulation',
            'to' => $to,
            'message' => $message,
            'ask_date' => date(\DateTime::ISO8601, $d),
            'wap' => 0,
            'flash' => 0,
            'class_version' => '1.9',
        ]);
        $this->setResponse([
            'id' => 100000001,
            'sms_count' => 1,
        ]);

        // event send sms
        event(new SendSms($this->getResponse(), $this->getData()));

        return true;
    }

    /**
     * IN: 	message_id to track delivery status
     * OUT: 	text name of status
     * @param $sms_id
     * @return mixed
     */
    public function receiveSMS($smsId)
    {
        $data = ['id' => $smsId];
        $result = $this->execute('receive', $data);
        if (count(@$result['errors']))
            $this->errors = $result['errors'];
        return @$result['status'];
    }

    /**
     * IN: 	message_id to delete
     * OUT: 	text name of status
     * @param $sms_id
     * @return mixed
     */
    public function deleteSMS($smsId)
    {
        $data = ['id' => $smsId];
        $result = $this->execute('delete', $data);
        if (count(@$result['errors']))
            $this->errors = $result['errors'];
        return @$result['status'];
    }

    /**
     * OUT:	amount in UAH, if no return - check errors
     * @return mixed
     */
    public function getBalance()
    {
        $result = $this->execute('balance');
        if (count(@$result['errors']))
            $this->errors = $result['errors'];
        return @$result['balance'];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * OUT:	returns number of errors
     * @return int
     */
    public function hasErrors()
    {
        return count($this->errors);
    }

    /**
     * OUT:	returns array of errors
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->lastResponse;
    }

    public function setResponse(array $response)
    {
        $this->lastResponse = $response;
    }
    /**
     * @param $string
     * @return string
     */
    public function translit($string)
    {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e', 'є' => 'ye',
            'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'і' => 'i',
            'и' => 'i', 'й' => 'j', 'к' => 'k', 'ї' => 'yi',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '"',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Є' => 'Ye',
            'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'І' => 'I',
            'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Ї' => 'Yi',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '"',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];
        $result = strtr($string, $converter);

        //upper case if needed
        if (mb_strtoupper($string) == $string)
            $result = mb_strtoupper($result);

        return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $result);
    }

    /**
     * @param $command
     * @param array $params
     * @return array|mixed
     */
    protected function execute($command, $params = [])
    {
        $this->errors = [];

        //HTTP GET
        if (strtolower($this->mode) == 'http') {
            $response = @file_get_contents($this->generateUrl($command, $params));

            return @unserialize($this->base64UrlDecode($response));
        } else {
            $params['login'] = $this->login;
            $params['password'] = $this->password;
            $params['key'] = $this->key;
            $params['command'] = $command;
            $params_url = '';

            foreach ($params as $key => $value) {
                $params_url .= '&' . $key . '=' . $this->base64UrlEncode($value);
            }

            //cURL HTTPS POST
            $ch = curl_init(strtolower($this->mode) . $this->server);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $response = @curl_exec($ch);
            curl_close($ch);

            $this->lastResponse = @unserialize($this->base64UrlDecode($response));

            /** add event send sms */
            if ($command != 'balance') {
                event(new SendSms($this->lastResponse, $this->getData()));
            }

            return $this->lastResponse;
        }
    }

    /**
     * @param $command
     * @param array $params
     * @return string
     */
    protected function generateUrl($command, $params = [])
    {
        $params_url = '';
        if (count($params))
            foreach ($params as $key => $value)
                $params_url .= '&' . $key . '=' . $this->base64UrlEncode($value);
        if (!$this->key) {
            $auth = '?login=' . $this->base64UrlEncode($this->login) . '&password=' . $this->base64UrlEncode($this->password);
        } else {
            $auth = '?key=' . $this->base64UrlEncode($this->key);
        }
        $command = '&command=' . $this->base64UrlEncode($command);
        return strtolower($this->mode) . $this->server . $auth . $command . $params_url;
    }

    /**
     * @param $input
     * @return string
     */
    public function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    /**
     * @param $input
     * @return bool|string
     */
    public function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }
}
