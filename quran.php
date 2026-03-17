<!DOCTYPE html>
<html>
<head>
    <title>Luxury Quran Viewer</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Poppins:wght@300;400;600&family=Amiri&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Poppins',sans-serif;
            background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);
            color:white;
        }

        nav{
            position:fixed;
            top:0;
            width:100%;
            padding:15px;
            background:rgba(0,0,0,0.6);
            backdrop-filter:blur(15px);
            text-align:center;
        }

        nav a{
            color:gold;
            margin:0 20px;
            text-decoration:none;
            font-weight:600;
        }

        .container{
            padding:120px 8%;
        }

        h1{
            text-align:center;
            font-family:'Cinzel',serif;
        }

        form{
            text-align:center;
            margin-bottom:40px;
        }

        select,button{
            padding:12px 20px;
            border-radius:30px;
            border:none;
            margin:10px;
        }

        button{
            background:gold;
            font-weight:bold;
            cursor:pointer;
        }

        .surah-box{
            background:rgba(255,255,255,0.08);
            padding:40px;
            border-radius:25px;
            backdrop-filter:blur(20px);
        }

        .surah-title{
            text-align:center;
            margin-bottom:20px;
        }

        .bismillah{
            text-align:center;
            font-family:'Amiri',serif;
            font-size:30px;
            color:gold;
            margin:20px 0;
        }

        .ayah{
            margin:25px 0;
            padding:20px;
            border-radius:15px;
            transition:0.3s;
        }

        .ayah:hover{
            background:rgba(255,255,255,0.05);
        }

        .arabic{
            font-family:'Amiri',serif;
            font-size:28px;
            direction:rtl;
            text-align:right;
            color:gold;
        }

        .translation{
            margin-top:10px;
            opacity:0.9;
        }

        .ayah-number{
            display:inline-block;
            background:gold;
            color:black;
            width:35px;
            height:35px;
            line-height:35px;
            text-align:center;
            border-radius:50%;
            margin-left:10px;
            font-weight:bold;
        }

        audio{
            width:100%;
            margin:20px 0;
        }

    </style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="quran.php">Quran</a>
    <a href="ayah.php">Ayah Of Quran</a>
</nav>

<div class="container">

<h1>Luxury Quran Surah Viewer</h1>

<form method="GET">
    <select name="surah" required>
        <option value="">Select Surah</option>
        <?php
        for($i=1; $i<=114; $i++){
            echo "<option value='$i'>Surah $i</option>";
        }
        ?>
    </select>
    <button type="submit">Show Surah</button>
</form>

<?php
if(isset($_GET['surah'])){

    $surah = intval($_GET['surah']);

    $api_url = "https://api.alquran.cloud/v1/surah/$surah/editions/ar.alafasy,en.asad";

    $response = @file_get_contents($api_url);

    if($response === FALSE){
        echo "<h3 style='color:red;'>Unable to load Surah. Check Internet or allow_url_fopen.</h3>";
    } else {

        $data = json_decode($response, true);

        if(isset($data['data'])){

            $arabic = $data['data'][0];
            $english = $data['data'][1];

            echo "<div class='surah-box'>";

            echo "<div class='surah-title'>";
            echo "<h2>".$arabic['englishName']." (".$arabic['name'].")</h2>";
            echo "<p>Revelation: ".$arabic['revelationType']."</p>";
            echo "</div>";

            // FULL SURAH AUDIO
            echo "<audio controls>";
            echo "<source src='https://cdn.islamic.network/quran/audio-surah/128/ar.alafasy/$surah.mp3' type='audio/mpeg'>";
            echo "</audio>";

            if($surah != 9){
                echo "<div class='bismillah'>بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>";
            }

            foreach($arabic['ayahs'] as $index => $ayah){

                echo "<div class='ayah'>";
                echo "<div class='arabic'>".$ayah['text']." <span class='ayah-number'>".$ayah['numberInSurah']."</span></div>";
                echo "<div class='translation'>".$english['ayahs'][$index]['text']."</div>";
                echo "</div>";
            }

            echo "</div>";
        }
    }
}
?>

</div>
</body>
</html>