<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>infobox show[one/Multiple]</title>
<style>html,body{height:100%;}body{padding:0;margin:0;}h1{padding:0;margin:0;font-size:50%;}</style>
</head>
<body>
    
    
<!-- MAP[START] -->
<h1>infobox show[one/Multiple]</h1>
<div id="myMap" style='width:100%;height:97%;'></div>
<!-- MAP[END] -->


<script src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=[  *** Your BingMapsAPI key. *** ]' async defer></script>
<script src="../js/BmapQuery.js"></script>
<script>
//****************************************************************************************
// BingMaps&BmapQuery
//****************************************************************************************
//Init
function GetMap(){

    //------------------------------------------------------------------------
    //1. Instance
    //------------------------------------------------------------------------
    const map = new Bmap("#myMap");

    //------------------------------------------------------------------------
    //2. Display Map
    //------------------------------------------------------------------------
    map.startMap(35.690056, 139.743389, "load", 10);

    //----------------------------------------------------
    //3. Infobox
    //   options = new Array();
    //   options[index] = { lat, lon, width, height, title, pinColor, description };
    //----------------------------------------------------
    const options = [];
    options[0]={
        "lat":35.6915961,
        "lon":139.7378098,
        "title":"市ヶ谷",
        "pinColor":"red",
        "height":200,
        "width":200,
        "description": '東京都千代田区五番町 九段南4-8-22 <br><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Ichigaya-Sta-201612.jpg/600px-Ichigaya-Sta-201612.jpg" width="100">',
        "show":false
    };
    options[1]={
        "lat":35.6854309,
        "lon":139.7416148,
        "title":"半蔵門",
        "pinColor":"blue",
        "height":200,
        "width":200,
        "description": '東京都千代田区 鞠町1-6<br><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Hanzomon-Sta-5.JPG/270px-Hanzomon-Sta-5.JPG" width="100">',
        "show":false
    };
    options[2]={
        "lat":35.6995999,
        "lon":139.7650042,
        "title":"御茶ノ水",
        "pinColor":"green",
        "height":200,
        "width":200,
        "description": '東京都千代田区 神田駿河台2丁目6<br><img src="https://lh5.googleusercontent.com/p/AF1QipMlkRMSH0BjtyHLUOiyge4eYB3KmiO_Pn-MTBzY=w408-h272-k-no" width="100">',
        "show":false
    };
    options[3]={
        "lat":35.6651924,
        "lon":139.7125071,
        "title":"表参道",
        "pinColor":"orange",
        "height":200,
        "width":200,
        "description": '東京都港区 北青山3丁目6-12<br><img src="https://lh5.googleusercontent.com/p/AF1QipNr129dcv9KPdd-pNGkEs1SMD2KrckQsJpe_pkw=w426-h240-k-no" width="100">',
        "show":false
    };
    options[4]={
        "lat":35.6690776,
        "lon":139.7035162,
        "title":"ジーズアカデミー東京",
        "pinColor":"purple",
        "height":200,
        "width":200,
        "description": '東京都渋谷区 神宮前6丁目35-3 JUNCTION harajuku011<br><img src="https://prtimes.jp/i/496/1842/resize/d496-1842-235759-1.jpg" width="100">',
        "show":false
    };
    //----------------------------------------------------
    //4. Switch infoboxs
    //   infoboxLayers(options, true); //true=one, false=Multiple
    //----------------------------------------------------
    map.infoboxLayers(options,true);

}
</script>

</body>
</html>