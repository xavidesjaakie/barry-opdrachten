<?php
session_start();

// --- Player class ---
class Player {
    public string $name;
    public string $color;
    public int $pos = 0; // positie op pad
    public int $round = 1; // ronde
    public function __construct(string $name, string $color){ 
        $this->name = $name; 
        $this->color = $color; 
    }
}


class Game {
    public array $players = [];
    public int $current = 0;
    public ?int $die1 = null;
    public ?int $die2 = null;
    public string $message = '';
    public int $rows = 9;
    public int $cols = 9;

    public function pathIndices(): array {
        $r=$this->rows; $c=$this->cols; $indices=[];
        for($col=0;$col<$c;$col++) $indices[] = $col; // top
        for($row=1;$row<$r;$row++) $indices[] = $row*$c + ($c-1); // rechts
        for($col=$c-2;$col>=0;$col--) $indices[] = ($r-1)*$c + $col; // onder
        for($row=$r-2;$row>=1;$row--) $indices[] = $row*$c; // links
        return $indices;
    }

    public function pathCount(): int { return count($this->pathIndices()); }
    public function addPlayer(Player $p){ $this->players[]=$p; }

    public function roll(): array {
        $this->die1 = random_int(1,6);
        $this->die2 = random_int(1,6);
        $steps = $this->die1 + $this->die2;
        $player = $this->players[$this->current];
        $from = $player->pos;
        $newPos = ($player->pos + $steps);
        $player->round += intdiv($newPos, $this->pathCount());
        $player->pos = $newPos % $this->pathCount();
        $to = $player->pos;

        if($this->die1 === $this->die2){
            $this->message = "{$player->name} gooide dubbel ({$this->die1}) en mag nogmaals! Rondje {$player->round}.";
        } else {
            $this->message = "{$player->name} liep {$steps} stappen ({$this->die1}+{$this->die2}). Rondje {$player->round}.";
            $this->current = ($this->current + 1) % count($this->players);
        }
        return ['player'=>array_search($player,$this->players,true),'from'=>$from,'to'=>$to,'roll'=>[$this->die1,$this->die2],'message'=>$this->message];
    }

    public function save(){
        $_SESSION['game']=[
            'rows'=>$this->rows,
            'cols'=>$this->cols,
            'current'=>$this->current,
            'die1'=>$this->die1,
            'die2'=>$this->die2,
            'message'=>$this->message,
            'players'=>array_map(fn($p)=>['name'=>$p->name,'color'=>$p->color,'pos'=>$p->pos,'round'=>$p->round], $this->players)
        ];
    }

    public static function load(): ?Game {
        if(empty($_SESSION['game']) || !isset($_SESSION['game']['players'])) return null;
        $d=$_SESSION['game']; $g=new Game();
        $g->rows=$d['rows']??$g->rows;
        $g->cols=$d['cols']??$g->cols;
        $g->current=$d['current']??0;
        $g->die1=$d['die1']??null;
        $g->die2=$d['die2']??null;
        $g->message=$d['message']??'';
        foreach($d['players'] as $p){
            $pl=new Player($p['name']??'Speler',$p['color']??'#f97316');
            $pl->pos = isset($p['pos'])?(int)$p['pos']:0;
            $pl->round = isset($p['round'])?(int)$p['round']:1;
            $g->addPlayer($pl);
        }
        return $g;
    }
}

// --- Requests ---
if($_SERVER['REQUEST_METHOD']==='POST'){
    $action=$_POST['action']??null;
    if($action==='new'){
        $num = max(1,min(4,(int)($_POST['players']??2)));
        $colors=['#f97316','#06b6d4','#34d399','#a78bfa'];
        $g = new Game();
        for($i=0;$i<$num;$i++){
            $name = !empty($_POST['player_name_'.$i]) ? substr(trim($_POST['player_name_'.$i]),0,20) : 'Speler '.($i+1);
            $g->addPlayer(new Player($name,$colors[$i%count($colors)]));
        }
        $g->save(); $_SESSION['popup']='Spel gestart!'; header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    if($action==='roll'){
        $g = Game::load()??new Game();
        $_SESSION['movement']=$g->roll(); $g->save(); header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
    if($action==='reset'){
        unset($_SESSION['game'],$_SESSION['movement']); $_SESSION['popup']='Nieuw spel klaar'; header('Location: '.$_SERVER['PHP_SELF']); exit;
    }
}

// --- Load game ---
$game = Game::load()??new Game();
if(empty($game->players)){
    $game->addPlayer(new Player('Speler 1','#f97316'));
    $game->addPlayer(new Player('Speler 2','#06b6d4'));
    $game->save();
}

$path=$game->pathIndices(); 
$pathCount=$game->pathCount(); 
$rows=$game->rows; 
$cols=$game->cols;
$players=$game->players; 
$current=$game->current;
$lastDie1=$game->die1??1; 
$lastDie2=$game->die2??1;
$movement=$_SESSION['movement']??null; if(isset($_SESSION['movement'])) unset($_SESSION['movement']);
$popup=$_SESSION['popup']??null; if(isset($_SESSION['popup'])) unset($_SESSION['popup']);

function render_die($v){
    $positions=[1=>[4],2=>[0,8],3=>[0,4,8],4=>[0,2,6,8],5=>[0,2,4,6,8],6=>[0,2,3,5,6,8]];
    $have=$positions[$v]??[4];
    $html='<div class="die">';
    for($i=0;$i<9;$i++) $html.='<span class="pip'.(in_array($i,$have)?' on':'').'"></span>';
    $html.='</div>'; return $html;
}
?>
<!doctype html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dobbelspel — Randpad 9×9</title>
<style>
:root{--bg:#071029;--card:#0b1220;--accent:#7dd3fc;--muted:#94a3b8}
*{box-sizing:border-box}
body{margin:0; background:linear-gradient(180deg,#071029 0%,#071733 100%); color:#e6eef8; font-family:Inter,system-ui,Arial; display:flex; align-items:center; justify-content:center; min-height:100vh; padding:16px}
.app{width:1100px; max-width:98%; background:rgba(255,255,255,0.02); border-radius:12px; padding:16px}
.header{display:flex; justify-content:space-between; align-items:center}
.title{font-weight:800}
.board-area{display:flex; gap:20px; margin-top:12px}
.board{background:rgba(255,255,255,0.02); padding:12px; border-radius:12px}
.grid{display:grid; grid-template-columns:repeat(9,1fr); width:720px; height:720px; gap:6px}
.cell{background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(0,0,0,0.04)); border-radius:8px; border:2px solid rgba(125,211,252,0.5); position:relative; display:flex; align-items:center; justify-content:center}
.cell.empty{background:#071029; border:0;}
.cell .index{position:absolute; top:6px; left:8px; font-size:12px; color:var(--muted)}
.pawns{position:absolute; bottom:8px; left:8px; display:flex; gap:6px}
.pawn{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;box-shadow:0 6px 12px rgba(0,0,0,0.5); transform:translateY(0); transition:transform 220ms ease}
.sidebar{width:340px; min-width:240px; padding:12px}
.btn{background:linear-gradient(90deg,var(--accent),#60a5fa); color:#042233; padding:10px 14px; border-radius:10px; border:none; font-weight:800; cursor:pointer; box-shadow:0 12px 30px rgba(13,148,255,0.08); transition:transform 140ms ease, box-shadow 140ms ease}
.btn:active{transform:translateY(3px) scale(0.99);}
.btn.secondary{background:transparent;color:var(--muted);border:1px solid rgba(255,255,255,0.04)}
.dice-block{display:flex;gap:12px;align-items:center;margin-top:10px}
.die{width:110px;height:110px;background:var(--card);border-radius:12px;display:grid;grid-template-columns:repeat(3,1fr);grid-template-rows:repeat(3,1fr);padding:12px;box-shadow:inset 0 -8px 24px rgba(0,0,0,0.6),0 8px 28px rgba(2,6,23,0.6)}
.pip{width:18px;height:18px;border-radius:50%;margin:auto;background:transparent}
.pip.on{background:linear-gradient(180deg,#f8fafc 0%,#e2e8f0 100%)}
.die.rolling{animation:roll 900ms cubic-bezier(.2,.9,.3,1)}
@keyframes roll{0%{transform:rotateX(0) rotateY(0)}30%{transform:rotateX(720deg) rotateY(360deg) translateY(-6px)}70%{transform:rotateX(1080deg) rotateY(720deg) translateY(2px)}100%{transform:rotateX(0) rotateY(0)}}
.popup{position:fixed;right:20px;top:20px;background:#062231;color:#dff6ff;padding:10px 14px;border-radius:8px;box-shadow:0 10px 30px rgba(0,0,0,0.5);opacity:0;transform:translateY(-8px);transition:opacity 260ms,transform 260ms}
.popup.show{opacity:1;transform:translateY(0)}
</style>
</head>
<body>
<div class="app">
  <div class="header">
    <div>
      <div class="title">Dobbelspel — 9×9 randpad</div>
      <div style="color:var(--muted)">Bordrand bevat <?php echo $pathCount; ?> vakjes — pionnen lopen rond de buitenrand.</div>
    </div>
    <div>
      <form method="post"><input type="hidden" name="action" value="reset"><button class="btn secondary">Reset</button></form>
    </div>
  </div>

  <div class="board-area">
    <div class="board">
      <div class="grid">
        <?php
        $map=array_flip($path);
        for($i=0;$i<$rows*$cols;$i++){
            $isPath=array_key_exists($i,$map);
            echo "<div class='".($isPath?'cell':'cell empty')."' data-grid='{$i}'".($isPath?" data-path='{$map[$i]}'":'').">";
            if($isPath) echo "<div class='index'>".($map[$i]+1)."</div>";
            echo "<div class='pawns' data-grid='{$i}'></div>";
            echo "</div>";
        }
        ?>
      </div>
    </div>

    <div class="sidebar">
      <div>Spelers — Beurt: <strong style="color:var(--accent)"><?php echo htmlspecialchars($players[$current]->name); ?></strong></div>
      <div style="margin-top:10px">
        <?php foreach($players as $i=>$p): ?>
          <div style="display:flex;align-items:center;gap:10px;padding:8px;border-radius:8px;background:rgba(255,255,255,0.01);margin-bottom:8px;border-left:4px solid <?php echo $p->color; ?>">
            <div class="pawn" style="background:<?php echo $p->color; ?>;width:28px;height:28px;"><?php echo $i+1; ?></div>
            <div style="flex:1">
              <div><?php echo htmlspecialchars($p->name); ?></div>
              <div style="color:var(--muted);font-size:13px">Padpositie: <?php echo $p->pos+1; ?> / Rondje: <?php echo $p->round; ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <form method="post">
        <input type="hidden" name="action" value="new">
        <label style="color:var(--muted)">Aantal spelers</label>
        <select name="players">
          <option value="2"<?php if(count($players)==2) echo ' selected'; ?>>2</option>
          <option value="3"<?php if(count($players)==3) echo ' selected'; ?>>3</option>
          <option value="4"<?php if(count($players)==4) echo ' selected'; ?>>4</option>
        </select>
        <button class="btn">Start spel</button>
      </form>

      <form id="rollForm" method="post" style="margin-top:10px">
        <input type="hidden" name="action" value="roll">
        <button type="button" id="rollBtn" class="btn">Gooi dobbelstenen</button>
      </form>

      <div class="dice-block">
        <?php echo render_die($lastDie1); echo render_die($lastDie2); ?>
      </div>

      <div id="status" style="margin-top:10px;color:var(--muted)"><?php echo htmlspecialchars($game->message ?: 'Klaar om te gooien.'); ?></div>

    </div>
  </div>
</div>

<div id="popup" class="popup"></div>

<script>
(function(){
const path=<?php echo json_encode($path); ?>;
const pathCount=<?php echo $pathCount; ?>;
let players=<?php echo json_encode(array_map(fn($p)=>['name'=>$p->name,'color'=>$p->color,'pos'=>$p->pos,'round'=>$p->round],$players)); ?>;
const rollBtn=document.getElementById('rollBtn');
const rollForm=document.getElementById('rollForm');
const dieA=document.querySelector('.die:nth-child(1)');
const dieB=document.querySelector('.die:nth-child(2)');
const popup=document.getElementById('popup');

function showPopup(text,ms=2200){popup.textContent=text;popup.classList.add('show');setTimeout(()=>popup.classList.remove('show'),ms);}
<?php if($popup): ?>showPopup(<?php echo json_encode($popup); ?>);<?php endif; ?>

function renderPawns(){
  document.querySelectorAll('.pawns').forEach(el=>el.innerHTML='');
  players.forEach((p,idx)=>{
    const gridIndex=path[p.pos%pathCount];
    const container=document.querySelector('.pawns[data-grid="'+gridIndex+'"]');
    if(container){const d=document.createElement('div');d.className='pawn';d.textContent=idx+1;d.style.background=p.color;container.appendChild(d);}
  });
}
renderPawns();

function startRollAnim(){
  dieA.classList.remove('rolling'); dieB.classList.remove('rolling'); void dieA.offsetWidth; dieA.classList.add('rolling'); dieB.classList.add('rolling');
}

rollBtn.addEventListener('click',()=>{
  startRollAnim();
  let ended=0;
  function onEnd(){ended++;if(ended>=1){dieA.removeEventListener('animationend',onEnd);dieB.removeEventListener('animationend',onEnd);setTimeout(()=>rollForm.submit(),90);}}
  dieA.addEventListener('animationend',onEnd); dieB.addEventListener('animationend',onEnd);
});

<?php if($movement): ?>
(function(){
  const m=<?php echo json_encode($movement); ?>;
  const playerIdx=m.player, from=m.from, to=m.to, msg=m.message;
  const steps=(to-from+pathCount)%pathCount;
  let cur=from;
  document.querySelectorAll('.pawns').forEach(el=>{
    const child=Array.from(el.children).find(ch=>Number(ch.textContent)===playerIdx+1);
    if(child) el.removeChild(child);
  });
  function step(){
    cur=(cur+1)%pathCount;
    const gridIndex=path[cur];
    const container=document.querySelector('.pawns[data-grid="'+gridIndex+'"]');
    if(container){const d=document.createElement('div');d.className='pawn';d.textContent=playerIdx+1;d.style.background=players[playerIdx].color;container.appendChild(d);}
    if(cur!==to) setTimeout(step,220); else {document.getElementById('status').textContent=msg;}
  }
  if(steps>0) setTimeout(step,450); else document.getElementById('status').textContent=msg;
})();
<?php endif; ?>

})();
</script>
</body>
</html>
