<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Luxury Quran Website</title>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Poppins:wght@300;400;600&family=Amiri&display=swap" rel="stylesheet">
<style>
/* --- Global Styles --- */
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    color:white;
    transition: background 0.5s, color 0.5s;
}
body.light{
    background:#f7f5f0;
    color:#222;
}

/* --- Dark/Light toggle --- */
#toggle-theme{
    position:fixed;
    top:20px;
    right:20px;
    padding:10px 15px;
    border-radius:25px;
    cursor:pointer;
    background:gold;
    border:none;
    font-weight:bold;
    z-index:1001;
}
body.light #toggle-theme{ background:#b86b00; color:white; }

/* --- Navbar --- */
nav{
    position:fixed;
    top:0;
    width:100%;
    padding:15px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(15px);
    text-align:center;
    z-index:1000;
    transition: background 0.5s;
}
body.light nav{ background: rgba(255,255,255,0.6); }
nav a{
    color: gold;
    margin:0 20px;
    font-weight:600;
    text-decoration:none;
}
body.light nav a{ color:#222; }

/* --- Hero Section --- */
.hero{
    height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    position:relative;
    overflow:hidden;
}
.hero h1{
    font-family:'Cinzel',serif;
    font-size:60px;
    margin-bottom:20px;
}
.hero p{
    font-size:20px;
    margin-bottom:40px;
    opacity:0.9;
}
.hero button{
    padding:15px 30px;
    border-radius:30px;
    border:none;
    background:gold;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}
.hero button:hover{ background:white; }

/* --- Surah Search --- */
#search-surah{
    padding:12px 20px;
    border-radius:30px;
    width:60%;
    max-width:300px;
    border:none;
    margin-top:10px;
}
body.light #search-surah{ background:#ddd; color:#222; }

/* --- Featured Surahs --- */
.featured{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin:60px 0;
}
.card{
    background: rgba(255,255,255,0.08);
    padding:30px;
    border-radius:25px;
    text-align:center;
    backdrop-filter:blur(15px);
    transition: transform 0.3s, background 0.3s;
}
.card:hover{
    transform: translateY(-10px);
    background: rgba(255,255,255,0.15);
}
body.light .card{ background: rgba(200,200,200,0.2); }
.card h3{ font-family:'Cinzel',serif; margin-bottom:10px; color:gold; }
body.light .card h3{ color:#b86b00; }
.card p{ opacity:0.9; margin-bottom:10px; }

/* --- Animated background pattern --- */
body::before{
    content:"";
    position:fixed;
    width:600px;
    height:600px;
    background: radial-gradient(circle, gold, transparent);
    top:-200px;
    right:-200px;
    opacity:0.05;
    animation: float 8s infinite alternate;
    z-index:0;
}
@keyframes float{
    from{transform:translateY(0);}
    to{transform:translateY(40px);}
}

/* --- Footer --- */
footer{
    text-align:center;
    padding:20px;
    opacity:0.7;
    margin-top:50px;
}

</style>
</head>
<body>

<button id="toggle-theme">🌙 Toggle Theme</button>

<nav>
    <a href="index.php">Home</a>
    <a href="quran.php">Quran</a>
    <a href="ayah.php">Ayah Of Quran</a>
</nav>

<div class="hero">
    <h1>🌙 Luxury Quran Website</h1>
    <p>Read, listen and explore the Holy Quran in Arabic and translation</p>
    <button onclick="document.getElementById('search-surah').scrollIntoView({behavior:'smooth'})">Explore Surahs</button>
    <input type="text" id="search-surah" placeholder="Search Surah by name">
</div>

<div class="container">
    <h2 style="text-align:center; margin-bottom:40px;">Featured Surahs</h2>
    <div class="featured" id="surah-list">
        <?php
        $all = @file_get_contents("https://api.alquran.cloud/v1/surah");
        if($all){
            $all_data = json_decode($all,true);
            foreach($all_data['data'] as $s){
                echo "<div class='card'>";
                echo "<h3>{$s['englishName']}</h3>";
                echo "<p>({$s['name']})</p>";
                echo "<p>Revelation: {$s['revelationType']}</p>";
                echo "<a href='quran.php?surah={$s['number']}' style='text-decoration:none;color:gold;font-weight:bold;'>Read Surah</a>";
                echo "</div>";
            }
        }
        ?>
    </div>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> Luxury Quran Website
</footer>

<script>
// ----- Dark/Light Toggle -----
const toggle = document.getElementById('toggle-theme');
toggle.addEventListener('click',()=>{
  document.body.classList.toggle('light');
});

// ----- Surah Search Filter -----
const searchInput = document.getElementById('search-surah');
searchInput.addEventListener('input',()=>{
  const val = searchInput.value.toLowerCase();
  document.querySelectorAll('#surah-list .card').forEach(card=>{
    const name = card.querySelector('h3').innerText.toLowerCase();
    const arabic = card.querySelector('p').innerText.toLowerCase();
    card.style.display = (name.includes(val) || arabic.includes(val)) ? 'block':'none';
  });
});
</script>

</body>
</html>