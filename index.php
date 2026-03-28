<?php
date_default_timezone_set('Europe/Brussels');

$targetParam = $_GET['target'] ?? '';
$defaultTarget = '2027-05-22T15:30'; // Exemple de date par défaut

function parseTarget(string $raw, string $fallback): DateTimeImmutable {
    $candidate = $raw !== '' ? $raw : $fallback;
    $candidate = str_replace(' ', 'T', $candidate);
    if (!preg_match('/T\d{2}:\d{2}(:\d{2})?$/', $candidate)) {
        if (!preg_match('/T\d{2}:\d{2}/', $candidate)) {
            $candidate .= 'T00:00';
        }
    }
    try {
        return new DateTimeImmutable($candidate, new DateTimeZone('Europe/Brussels'));
    } catch (Exception $e) {
        return new DateTimeImmutable($fallback, new DateTimeZone('Europe/Brussels'));
    }
}

$target = parseTarget($targetParam, $defaultTarget);
$now = new DateTimeImmutable('now', new DateTimeZone('Europe/Brussels'));
$past = $target <= $now;
$interval = $now->diff($target);
$seconds = max(0, $target->getTimestamp() - $now->getTimestamp());

// --- Citations romantiques ---
$quotes = [
    "Deux âmes, un seul cœur : Virginie & Nordine pour toujours 💞",
    "L’amour, c’est toi et moi, aujourd’hui et à jamais.",
    "Le compte à rebours du plus beau jour de notre vie a commencé.",
    "Le mariage, c’est la promesse d’un toujours ensemble.",
    "Chaque jour passé ensemble est un cadeau précieux.",
    "Le vrai bonheur, c’est de construire un avenir à deux.",
    "Bientôt le début d’une éternité à deux 💍",
    "Le destin nous a unis, et le mariage scellera notre amour.",
    "Notre histoire d’amour devient éternelle.",
    "Bientôt, nos cœurs battront à l’unisson pour la vie entière.",
    "Le plus beau des voyages commence à deux.",
    "Notre amour est la plus belle promesse de bonheur.",
    "Deux cœurs, une vie, un amour sans fin.",
    "Chaque seconde nous rapproche du grand ‘Oui’ 💗",
    "L’amour rend chaque instant magique.",
    "Aujourd’hui fiancés, demain mariés, pour toujours liés.",
    "Main dans la main, nous allons écrire notre histoire.",
    "Le mariage, c’est l’amour célébré par le temps.",
    "Virginie & Nordine : une histoire d’amour qui devient éternelle.",
    "Notre ‘pour toujours’ commence bientôt 💕"
];

$quote = $quotes[array_rand($quotes)];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mariage de Virginie & Nordine 💍</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 40%, #e0f2fe 100%);
      font-family: 'Playfair Display', serif;
      color: #5b3b36;
      overflow-x: hidden;
    }
    .glass { backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.5); }
    .title { font-family: 'Great Vibes', cursive; color: #db2777; }
    .count-number { font-size: 3rem; font-weight: bold; color: #db2777; }
    .heart { color: #db2777; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.2)} }
    .fade-in { animation: fadeIn 1s ease forwards; opacity: 0; }
    @keyframes fadeIn { to { opacity: 1; } }
  </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen px-4 py-10 text-center fade-in">

  <div class="max-w-4xl w-full space-y-8">
    <h1 class="title text-5xl md:text-6xl mb-4">💞 Virginie & Nordine 💞</h1>
    <p class="text-lg md:text-xl opacity-80">Le grand jour approche… le <strong><?php echo $target->format('d F Y à H\hi'); ?></strong></p>

    <div class="glass rounded-3xl p-8 shadow-2xl">
      <div class="italic text-2xl md:text-3xl text-rose-700">« <span id="quote-text"><?php echo $quote; ?></span> »</div>
    </div>

    <div class="glass rounded-3xl p-10 shadow-2xl">
      <h2 class="text-2xl font-bold text-rose-700 mb-4">⏰ Compte à rebours avant le mariage</h2>

      <div id="countdown" class="flex flex-wrap justify-center gap-6 text-center mb-4">
        <div><div class="count-number" id="days">0</div><div class="text-sm">Jours</div></div>
        <div><div class="count-number" id="hours">0</div><div class="text-sm">Heures</div></div>
        <div><div class="count-number" id="minutes">0</div><div class="text-sm">Minutes</div></div>
        <div><div class="count-number" id="seconds">0</div><div class="text-sm">Secondes</div></div>
      </div>

      <div id="message" class="text-2xl font-semibold mt-4"></div>

      <form method="get" class="mt-8 flex flex-col gap-3 max-w-sm mx-auto">
        <label for="target" class="text-sm opacity-75">Changer la date ou l’heure du mariage 💒</label>
        <input type="datetime-local" id="target" name="target"
               value="<?php echo htmlspecialchars($target->format('Y-m-d\TH:i'), ENT_QUOTES); ?>"
               class="w-full rounded-xl p-3 border border-rose-300 text-gray-800 focus:ring-2 focus:ring-rose-400" />
        <button type="submit"
                class="bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-4 py-3 mt-2 font-semibold shadow">
          Mettre à jour
        </button>
      </form>
    </div>

    <footer class="text-sm text-rose-700 opacity-70 mt-8">
      Fait avec <span class="heart">♥</span> par Virginie & Nordine
    </footer>
  </div>

<script>
(function(){
  const target = new Date('<?php echo $target->format('Y-m-d\TH:i:s'); ?>');
  const daysEl = document.getElementById('days');
  const hoursEl = document.getElementById('hours');
  const minutesEl = document.getElementById('minutes');
  const secondsEl = document.getElementById('seconds');
  const messageEl = document.getElementById('message');
  const quoteEl = document.getElementById('quote-text');
  const quotes = <?php echo json_encode($quotes); ?>;

  function updateCountdown() {
    const now = new Date();
    const diff = target - now;

    if (diff <= 0) {
      messageEl.textContent = "🎉 C’est le grand jour ! Félicitations Virginie & Nordine 💖";
      daysEl.textContent = hoursEl.textContent = minutesEl.textContent = secondsEl.textContent = "0";
      return;
    }

    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const m = Math.floor((diff / (1000 * 60)) % 60);
    const s = Math.floor((diff / 1000) % 60);

    daysEl.textContent = d;
    hoursEl.textContent = h;
    minutesEl.textContent = m;
    secondsEl.textContent = s;
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);

  // Change la citation toutes les 30 secondes
  setInterval(() => {
    quoteEl.textContent = quotes[Math.floor(Math.random() * quotes.length)];
  }, 30000);
})();
</script>
</body>
</html>
