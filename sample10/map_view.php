<?php
 //**********************************************************
 // *  fileupload2.php
 // *  FileList（画像ファイル一覧表示）
 //**********************************************************
//１．DB接続
try {
    //dbname=gs_db
    //host=localhost
    //Password:MAMP='root', XAMPP=''
    $pdo = new PDO('mysql:dbname=map_db;charset=utf8;host=localhost','root','');
                                                                    //DBのID名,PW
} catch (PDOException $e) {
    exit('DB_ConnectError:'.$e->getMessage()); //DB接続：Error表示
}

//SELECT文を作る
$sort  = "input_date";  //SQL:SORT用
$sql = "SELECT * FROM map_tables ORDER BY :sort DESC"; //SQL文
                                    //バインド変数を埋め込むので :sort
                                    //SQLインジェクション（脆弱性）の関係で $sort （直接変数を埋め込む）は駄目
$stmt = $pdo->prepare($sql);   //SQLをセット
$stmt->bindValue(":sort",  $sort);   //SQL:SORT用　バインド変数を作成して2行上のコードに渡す
                //↑バインド変数
                //bindValue関数のサニタイジング（無効化）で、危険なコマンドや変数が :sort に入っても無効化してくれる
$status = $stmt->execute();  //実行
//DB接続、データの取得↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//-------------------------------------------------------------------------------------------------------------------

//Javascriptにデータを渡してマップに表示する文字列作成↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//JS用 配列文字列を作成
$img=""; //画像名の配列文字列
$lat=""; //lat:緯度の配列数値
$lon=""; //lon:経度の配列数値
$shop="";
$howmuch="";
//let a = ['a.jpg','b.jpg','c.jpg'];
//下記のif文で上記のデータを取り出し、let a = ['a.jpg','b.jpg','c.jpg'];　の形にする

$i = 0;
if($status==false){
    //SQLエラーの文字列を作成   
    $view = "SQLError"; //SQLエラーの文字列を作成
}else{    
    //配列のインデックスで使用する変数iを作成

    //取得したレコード数ループでデータ取得
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){   //ループに成功したら1行ずつ取り出し（1レコード取得）
        //let a = ['a.jpg','b.jpg','c.jpg'];のための処理
        if($i==0){  //初回のみ a.jpg を作成、2回目以降は file
            //1回目のみ実行
            $img     .= '"'.$row["img"].'"';
            $lat     .= $row["lat"];
            $lon     .= $row["lon"];
            $name    .= '"'.$row["name"].'"';
            $shop    .= '"'.$row["shop"].'"';
            $howmuch .= '"'.$row["howmuch"].'"';
        }else{
            //2回目以降はこちら（2回目から先頭にカンマを付与）
            $img     .= ',"'.$row["img"].'"';
            $lat     .= ",".$row["lat"];
            $lon     .= ",".$row["lon"];
            $name    .= ',"'.$row["name"].'"';
            $shop    .= ',"'.$row["shop"].'"';
            $howmuch .= ',"'.$row["howmuch"].'"';
        }
        //$iをインクリメント
        $i++;
    }
    //echo $lon;
    //exit;
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>写真アップロード</title>
<style>
body{width:100%;height:100%;margin:0;padding:0;}
#photarea{padding:5%;width:100%;background:black;}
img{height:100px;}
</style>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="main">


<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="#">地図</a></div>
      <ul class="pager">
      <li class="previous"><a href="index.html">← 新規登録</a></li>
      <li class="next disabled"><a href="file_view.php">画像一覧</a></li>
      </ul>
     </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- IMG_LIST[Start] -->
<div id="myMap" style="width:1150px;height:450px;"></div>
<!-- IMG_LIST[END] -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AoLKa2ak3eV72jUquDqsMlbmvb9qgCVhaCPjo3Llsz4AL6HmouUBrwVEOdDsfFET' async defer></script>         
                                                <!--マップライブラリを読み込んだら（callback）GetMapが実行される-->
<script src="js/BmapQuery.js"></script>
<script>
//1.配列
let img  = [<?=$img?>];
let lat  = [<?=$lat?>];
let lon  = [<?=$lon?>];
let name = [<?=$name?>];
let shop = [<?=$shop?>];
let howmuch = [<?=$howmuch?>];

//2.BingMapライブラリを読み込んだらGetmap関数を実行！
//* MapObjectをグローバルで保持
let map;        //#myMapのオブジェクト変数は外に記述
//* MapZoom値
let zoom = 12;

function GetMap(){
    //BingMapが読み込まれたらスタート
    //BingMapキーの隣にあるcallbackより、全てのライブラリを読み込めたら最後に実行
    //Mapライブラリは重いので上記の順序
    map = new Bmap("#myMap");
    map.startMap(47.6149, -122.1941, "load", zoom); //The place is Bellevue.

    // pin&InfoBoxを挿入
    //* 配列の長さを取得
    let len = lat.length;
    //* forループで配列の数だけ処理をする
    for(let i=0; i<len; i++){
        //* 最初にpin,次にinfoboxHtml
        map.pin(lat[i],lon[i],"#ff0000");
        let h = '<div><div style="background-color:#ffffff;">'+name[i]+'<div>'+shop[i]+'<div>'+howmuch[i]+'<br><img src="upload/'+img[i]+'"></div></div>'
        map.infoboxHtml(lat[i],lon[i], h);
    }
    //* map.changeMapを使って最後の座標を中心に表示する！
    map.changeMap(lat[len-1], lon[len-1], "load",zoom);        //len=長さ、三個数値が格納されているので-1することで二番目の数を指定、lat[i],lon[i]の場所に中央表示する
}
</script>
</body>
</html>



