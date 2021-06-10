
<?php
// 【設問１】
function test_func(int $v1, int $v2, int $v3): string
{
    $num = pow($v1, $v2);
    if ($num >= 0 &&   $num <= $v3){
        return (string)$num;
    } else {
        return "該当する値が存在しません";
    }
}

$v1 = 2;
$v2 = 3;
$v3 = 20;
echo test_func($v1, $v2, $v3);

?>

<?php
// 【設問２】
function getAddress($baseUrl, $zipCode, $appId)
{
    $url = $baseUrl . $zipCode . '&appid='. $appId . '&output=json';
    $addressData = file_get_contents($url);
    $res = json_decode($addressData, true);
    $address = $res[Feature][0][Property][Address];
    return '郵便番号が' . $zipCode . 'の住所は，' .$address . 'です。';
}

const ZIP_CODE = '532-0011';
const BASE_URL = 'https://map.yahooapis.jp/search/zip/V1/zipCodeSearch?query=';
const APP_ID = 'dj00aiZpPVZ0ek43eXZrUkYyaiZzPWNvbnN1bWVyc2VjcmV0Jng9NTM-';

echo getAddress(BASE_URL, ZIP_CODE, APP_ID)
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>郵便番号検索</title>
</head>
<body>
  <p><?= $address; ?></p>
</body>
</html>

<?php
// 【設問３】
class Person {
    // 名前
    protected $name;
    // 生年月日(年/月/日)
    private $birthday;
    // 性別(m:男性, f:女性)
    private $gender;
    // 1.-(1)名前、生年月日、性別の情報を受け取りプロパティを初期化するコンストラクタを作成
    public function __construct($name, $birthday, $gender){
        $this->name = $name;
        $this->birthday = $birthday;
        $this->gender = $gender;
        }

    // 2.-(2)で「男性」等の表記とするため，関数を定義
    protected function getGendata(){
        if($this->gender == 'm'){
            $gendata = '男性';
        }else if($this->gender == 'f'){
            $gendata = '女性';
        }else{
            $gendata = '[性別は不明]';
        }
        return $gendata;
    }
    // 自己紹介文を生成
    public function selfIntroduction(){
        return 'わたしは' . $this->name . '、' . $this->birthday . '生まれ、' . $this->getGendata() . 'です。'. PHP_EOL;
    }
    // 1.-(2)生年月日から年齢を算出し返す「getAge」メソッドを作成
    protected function getAge(){
        $now_ymd = date('Ymd');
        $birthday_ymd = str_replace("/", "", $this->birthday);
        $age = floor(($now_ymd - $birthday_ymd)/10000);
        return $age;
    }
}

class Profile extends Person {
    private $hometown;
    private $hobby;
    // 2.-(1)「hometown(出身地)」「hobby(趣味)」プロパティを作成しコンストラクタで初期化
    public function __construct($name, $birthday, $gender, $hometown, $hobby){
        parent::__construct($name, $birthday, $gender);
        $this->hometown = $hometown;
        $this->hobby = $hobby;
    }

    // 2.-(2)「Person」クラスの「selfIntroduction」メソッドをオーバーライド
    public function selfIntroduction(){
    $introduce = <<<EOD
私の名前は{$this->name}です。
{$this->getAge()}才、{$this->getGendata()}です。
出身は{$this->hometown}、趣味は{$this->hobby}です。

EOD;
    return $introduce;
    }
}
$tanaka = new Person('田中', '1990/07/01', 'm');
echo $tanaka->selfIntroduction();

$kawakami = new Profile('川上', '1981/06/12', 'f', '三重県','読書');
echo $kawakami->selfIntroduction();

