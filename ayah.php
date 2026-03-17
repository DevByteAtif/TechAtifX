<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ayah of the Quran</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Poppins:wght@300;400;600&family=Amiri&display=swap" rel="stylesheet">
<style>
body{
  margin:0;
  font-family:'Poppins',sans-serif;
  background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
  color:white;
  transition: background 0.5s, color 0.5s;
}
body.light{ background:#f7f5f0; color:#222; }

nav{
  position:fixed; top:0; width:100%; padding:15px;
  background: rgba(0,0,0,0.6);
  backdrop-filter: blur(15px);
  text-align:center; z-index:1000;
}
body.light nav{ background: rgba(255,255,255,0.6); }
nav a{ color: gold; margin:0 20px; text-decoration:none; font-weight:600; }
body.light nav a{ color:#222; }

.container{ padding:120px 8%; max-width:800px; margin:auto; text-align:center; }
h1{ font-family:'Cinzel',serif; margin-bottom:30px; }

select,button{ padding:12px 20px; border-radius:30px; border:none; margin:10px; font-size:16px; }
button{ background:gold; font-weight:bold; cursor:pointer; transition:0.3s; }
button:hover{ background:white; }
body.light button{ background:#b86b00; color:white; }

.ayah-box{
  background: rgba(255,255,255,0.08);
  border-radius:25px;
  backdrop-filter: blur(15px);
  padding:40px;
  margin-top:40px;
}
body.light .ayah-box{ background: rgba(200,200,200,0.2); }

.arabic{ font-family:'Amiri',serif; font-size:28px; direction:rtl; text-align:right; color:gold; margin-bottom:15px; }
body.light .arabic{ color:#b86b00; }

.translation{ font-size:18px; opacity:0.9; margin-bottom:20px; }

.audio-container{ margin:20px 0; }
audio{ width:100%; border-radius:15px; }

#toggle-theme{
  position:fixed; top:20px; right:20px; padding:10px 15px; border-radius:25px; cursor:pointer; background:gold; border:none; font-weight:bold; z-index:1001;
}
body.light #toggle-theme{ background:#b86b00; color:white; }

body::before{
  content:"";
  position:fixed; width:600px; height:600px;
  background: radial-gradient(circle, gold, transparent);
  top:-200px; right:-200px;
  opacity:0.05;
  animation: float 8s infinite alternate;
  z-index:0;
}
@keyframes float{ from{transform:translateY(0);} to{transform:translateY(40px);} }
</style>
</head>
<body>

<button id="toggle-theme">🌙 Toggle Theme</button>

<nav>
  <a href="index.php">Home</a>
  <a href="ayah.php">Ayah</a>
  <a href="quran.php">Quran</a>
</nav>

<div class="container">
<h1>Ayah of the Quran</h1>

<form method="GET">
<select name="surah" required>
  <option value="">Select Surah</option>
  <?php
    $all = @file_get_contents("https://api.alquran.cloud/v1/surah");
    if($all){
      $all_data = json_decode($all,true);
      foreach($all_data['data'] as $s){
        echo "<option value='{$s['number']}'>{$s['englishName']} ({$s['name']})</option>";
      }
    }
  ?>
</select>
<input type="number" name="ayah" placeholder="Ayah number" min="1" required>
<button type="submit">Show Ayah</button>
</form>

<?php
if(isset($_GET['surah']) && isset($_GET['ayah'])){
  $surah = intval($_GET['surah']);
  $ayahNum = intval($_GET['ayah']);

  // Arabic edition
  $ar = @file_get_contents("https://api.alquran.cloud/v1/ayah/{$surah}:{$ayahNum}/ar.alafasy");
  $ar_data = $ar ? json_decode($ar,true) : null;

  // English edition
  $en = @file_get_contents("https://api.alquran.cloud/v1/ayah/{$surah}:{$ayahNum}/en.asad");
  $en_data = $en ? json_decode($en,true) : null;

  if($ar_data && $en_data && isset($ar_data['data']) && isset($en_data['data'])){
      $arabic_text = $ar_data['data']['text'];
      $english_text = $en_data['data']['text'];
      $audio = $ar_data['data']['audio'];

      echo "<div class='ayah-box'>";
      echo "<div class='arabic'>{$arabic_text} <span class='ayah-number'>{$ayahNum}</span></div>";
      echo "<div class='translation'>{$english_text}</div>";
      echo "<div class='audio-container'><audio controls><source src='{$audio}' type='audio/mpeg'></audio></div>";
      echo "</div>";
  } else {
      echo "<p style='color:red;'>Ayah not found or API error.</p>";
  }
}
?>

<script>
// Dark/Light toggle
const toggle = document.getElementById('toggle-theme');
toggle.addEventListener('click',()=>{ document.body.classList.toggle('light'); });
</script>

</body>
</html>