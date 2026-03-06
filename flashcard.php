<?php
require_once __DIR__ . "/db.php"; requireLogin(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Flashcard Tiếng Anh — MindSpark</title>
<link rel="stylesheet" href="style.css">
<style>
/* MODE SWITCH */
.mode-tabs{display:flex;gap:0.5rem;margin-bottom:1.2rem;}
.mode-tab{flex:1;padding:0.75rem;border-radius:12px;border:2px solid var(--border);background:var(--surface2);cursor:pointer;text-align:center;font-weight:700;font-size:0.9rem;transition:all 0.2s;}
.mode-tab.active{border-color:var(--accent);background:rgba(99,102,241,0.15);color:#a5b4fc;}

/* CHIPS */
.chip-group{display:flex;flex-wrap:wrap;gap:0.4rem;margin-top:0.5rem;}
.chip{padding:0.25rem 0.7rem;border-radius:20px;border:1px solid var(--border);background:var(--surface2);font-size:0.78rem;cursor:pointer;transition:all 0.18s;}
.chip:hover,.chip.active{border-color:var(--accent);background:rgba(99,102,241,0.18);color:#a5b4fc;}
.label{font-family:var(--font-head);font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--muted);margin:0.8rem 0 0.35rem;}

/* FLASHCARD */
.fc-scene{perspective:1200px;cursor:pointer;margin-bottom:1rem;}
.fc-card{position:relative;width:100%;height:250px;transform-style:preserve-3d;transition:transform 0.55s cubic-bezier(.4,2,.55,1);border-radius:14px;}
.fc-card.flipped{transform:rotateY(180deg);}
.fc-face{position:absolute;inset:0;backface-visibility:hidden;border-radius:14px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;text-align:center;border:1px solid var(--border);}
.fc-front{background:linear-gradient(135deg,#1a2236,#131929);}
.fc-back{background:linear-gradient(135deg,#0f2419,#0b1a10);transform:rotateY(180deg);border-color:rgba(52,211,153,0.3);}
.fc-hint{font-family:var(--font-head);font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;opacity:0.4;margin-bottom:0.7rem;}
.fc-word{font-size:2rem;font-weight:800;margin-bottom:0.3rem;}
.fc-phonetic{font-size:0.9rem;opacity:0.5;font-style:italic;margin-bottom:0.3rem;}
.fc-type{font-size:0.72rem;background:rgba(99,102,241,0.2);color:#a5b4fc;padding:0.15rem 0.55rem;border-radius:20px;}
.fc-meaning{font-size:1.25rem;font-weight:700;color:var(--green);margin-bottom:0.5rem;}
.fc-example{font-size:0.82rem;opacity:0.6;line-height:1.6;max-width:380px;}
.fc-nav{display:flex;align-items:center;justify-content:center;gap:0.75rem;margin-bottom:1rem;}
.fc-counter{font-family:var(--font-head);font-weight:700;color:var(--muted);min-width:60px;text-align:center;}
.fc-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:0.5rem;margin-top:0.5rem;}
.fc-mini{background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:0.7rem;font-size:0.82rem;cursor:pointer;transition:border-color 0.18s;}
.fc-mini:hover{border-color:var(--accent);}
.fc-mini.known{border-color:var(--green);background:rgba(52,211,153,0.07);}

/* TEXTAREA */
.word-input{width:100%;min-height:120px;background:var(--surface2);border:1px solid var(--border);border-radius:10px;padding:0.8rem;color:var(--text);font-size:0.9rem;resize:vertical;font-family:inherit;}
.word-input:focus{outline:none;border-color:var(--accent);}
</style>
</head>
<body>
<?php require_once __DIR__ . "/db.php"; include 'navbar.php'; ?>
<div class="page">
  <h1 class="page-title">🇬🇧 Flashcard Tiếng Anh</h1>

  <!-- MODE TABS -->
  <div class="mode-tabs">
    <div class="mode-tab active" id="tab1" onclick="switchMode(1)">🎲 Học ngẫu nhiên<br><small style="font-weight:400;opacity:0.6;">AI tự chọn từ vựng</small></div>
    <div class="mode-tab" id="tab2" onclick="switchMode(2)">📋 Danh sách của tôi<br><small style="font-weight:400;opacity:0.6;">Nhập từ có sẵn</small></div>
  </div>

  <!-- MODE 1: AI tự chọn -->
  <div id="mode1">
    <div class="card" style="margin-bottom:1.2rem;">
      <div class="card-body">
        <div class="label">📂 Chủ đề</div>
        <div class="chip-group" id="topicChips">
          <span class="chip active" onclick="selectChip('topic',this,'Giao tiếp hàng ngày')">💬 Giao tiếp</span>
          <span class="chip" onclick="selectChip('topic',this,'IELTS Academic')">📚 IELTS</span>
          <span class="chip" onclick="selectChip('topic',this,'TOEIC Business')">💼 TOEIC</span>
          <span class="chip" onclick="selectChip('topic',this,'Du lịch')">✈️ Du lịch</span>
          <span class="chip" onclick="selectChip('topic',this,'Công nghệ')">💻 Công nghệ</span>
          <span class="chip" onclick="selectChip('topic',this,'Cảm xúc & Tính cách')">❤️ Cảm xúc</span>
          <span class="chip" onclick="selectChip('topic',this,'Idioms thông dụng')">🎯 Idioms</span>
          <span class="chip" onclick="selectChip('topic',this,'Phrasal verbs')">⚡ Phrasal verbs</span>
          <span class="chip" onclick="selectChip('topic',this,'Môi trường')">🌿 Môi trường</span>
          <span class="chip" onclick="selectChip('topic',this,'Sức khỏe')">🏥 Sức khỏe</span>
        </div>

        <div class="label">📊 Trình độ</div>
        <div class="chip-group" id="levelChips">
          <span class="chip" onclick="selectChip('level',this,'A1-A2')">🟢 A1–A2 Cơ bản</span>
          <span class="chip active" onclick="selectChip('level',this,'B1-B2')">🟡 B1–B2 Trung cấp</span>
          <span class="chip" onclick="selectChip('level',this,'C1-C2')">🔴 C1–C2 Nâng cao</span>
        </div>

        <div class="label">📝 Loại từ</div>
        <div class="chip-group" id="typeChips">
          <span class="chip active" onclick="selectChip('type',this,'tất cả')">🔀 Tất cả</span>
          <span class="chip" onclick="selectChip('type',this,'danh từ')">🏷️ Danh từ</span>
          <span class="chip" onclick="selectChip('type',this,'động từ')">⚡ Động từ</span>
          <span class="chip" onclick="selectChip('type',this,'tính từ')">🎨 Tính từ</span>
          <span class="chip" onclick="selectChip('type',this,'trạng từ')">🔄 Trạng từ</span>
        </div>

        <div style="margin-top:1rem;">
          <button class="btn btn-primary" onclick="generateAI()" id="aiBtn" style="width:100%;">✨ Tạo flashcard ngẫu nhiên</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODE 2: Nhập từ có sẵn -->
  <div id="mode2" style="display:none;">
    <div class="card" style="margin-bottom:1.2rem;">
      <div class="card-body">
        <div class="label">📋 Nhập danh sách từ vựng</div>
        <p style="font-size:0.83rem;color:var(--muted);margin-bottom:0.75rem;">Mỗi từ một dòng. Có thể kèm nghĩa hoặc không, AI sẽ tự tra.</p>
        <textarea class="word-input" id="wordList" placeholder="Ví dụ:
ephemeral
ameliorate
serendipity
ubiquitous: có mặt khắp nơi
perseverance
..."></textarea>
        <div style="margin-top:0.75rem;">
          <button class="btn btn-primary" onclick="generateFromList()" id="listBtn" style="width:100%;">📖 Tạo flashcard từ danh sách</button>
        </div>
      </div>
    </div>
  </div>

  <!-- FLASHCARD AREA -->
  <div id="fcArea" style="display:none;">
    <div class="card">
      <div class="card-header">
        <div class="card-title" id="fcLabel"></div>
        <div style="display:flex;align-items:center;gap:0.75rem;">
          <div class="progress-wrap" style="width:100px;"><div class="progress-fill" id="fcProg" style="width:0%;background:var(--green);"></div></div>
          <span id="fcProgText" style="font-family:var(--font-head);font-size:0.78rem;color:var(--muted);"></span>
        </div>
      </div>
      <div class="card-body">
        <div class="fc-scene" onclick="flipCard()">
          <div class="fc-card" id="fcCard">
            <div class="fc-face fc-front">
              <div class="fc-hint">🇬🇧 Tiếng Anh · Nhấn để xem nghĩa</div>
              <div class="fc-word" id="fcWord"></div>
              <div class="fc-phonetic" id="fcPhonetic"></div>
              <div class="fc-type" id="fcType"></div>
            </div>
            <div class="fc-face fc-back">
              <div class="fc-hint">🇻🇳 Nghĩa tiếng Việt</div>
              <div class="fc-meaning" id="fcMeaning"></div>
              <div class="fc-example" id="fcExample"></div>
            </div>
          </div>
        </div>
        <div class="fc-nav">
          <button class="btn btn-ghost btn-sm" onclick="prevCard()">← Trước</button>
          <span class="fc-counter" id="fcCount"></span>
          <button class="btn btn-success btn-sm" onclick="markKnown()">✓ Đã thuộc</button>
          <button class="btn btn-ghost btn-sm" onclick="nextCard()">Tiếp →</button>
        </div>
        <div class="label">Tất cả từ</div>
        <div class="fc-grid" id="fcGrid"></div>
      </div>
    </div>
  </div>
</div>

<script>
let cards=[], idx=0, known=new Set(), flipped=false;
let selected = { topic:'Giao tiếp hàng ngày', level:'B1-B2', type:'tất cả' };

function switchMode(m){
  document.getElementById('mode1').style.display = m===1?'block':'none';
  document.getElementById('mode2').style.display = m===2?'block':'none';
  document.getElementById('tab1').classList.toggle('active', m===1);
  document.getElementById('tab2').classList.toggle('active', m===2);
  document.getElementById('fcArea').style.display='none';
}

function selectChip(key, el, val){
  selected[key]=val;
  el.closest('.chip-group').querySelectorAll('.chip').forEach(c=>c.classList.remove('active'));
  el.classList.add('active');
}

async function generateAI(){
  const btn=document.getElementById('aiBtn');
  btn.disabled=true; btn.textContent='⏳ Đang tạo...';
  try{
    const res=await fetch('ai_api.php',{method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({type:'flashcard_en', topic:selected.topic, level:selected.level, wordType:selected.type})});
    const data=await res.json();
    loadCards(data.cards||[], `${selected.topic} · ${selected.level}`);
  }catch(e){alert('Lỗi tạo card!');}
  btn.disabled=false; btn.textContent='✨ Tạo flashcard ngẫu nhiên';
}

async function generateFromList(){
  const raw=document.getElementById('wordList').value.trim();
  if(!raw) return alert('Nhập từ vựng đi!');
  const btn=document.getElementById('listBtn');
  btn.disabled=true; btn.textContent='⏳ Đang tra từ...';
  try{
    const res=await fetch('ai_api.php',{method:'POST',headers:{'Content-Type':'application/json'},
      body:JSON.stringify({type:'flashcard_list', words:raw})});
    const data=await res.json();
    loadCards(data.cards||[], 'Danh sách của tôi');
  }catch(e){alert('Lỗi tạo card!');}
  btn.disabled=false; btn.textContent='📖 Tạo flashcard từ danh sách';
}

function loadCards(c, label){
  cards=c; idx=0; known=new Set(); flipped=false;
  document.getElementById('fcLabel').textContent='📚 '+label;
  document.getElementById('fcArea').style.display='block';
  document.getElementById('fcArea').scrollIntoView({behavior:'smooth'});
  renderCard(); renderGrid(); updateProg();
}

function renderCard(){
  const c=cards[idx];
  document.getElementById('fcWord').textContent=c.word;
  document.getElementById('fcPhonetic').textContent=c.phonetic||'';
  document.getElementById('fcType').textContent=c.type||'';
  document.getElementById('fcMeaning').textContent=c.meaning;
  document.getElementById('fcExample').innerHTML=`<em>"${c.example}"</em><br><span style="color:var(--green);opacity:0.8">${c.example_vi||''}</span>`;
  document.getElementById('fcCount').textContent=(idx+1)+' / '+cards.length;
  document.getElementById('fcCard').classList.remove('flipped'); flipped=false;
}
function flipCard(){flipped=!flipped;document.getElementById('fcCard').classList.toggle('flipped',flipped);}
function prevCard(){if(idx>0){idx--;renderCard();}}
function nextCard(){if(idx<cards.length-1){idx++;renderCard();}}
function markKnown(){known.add(idx);updateProg();renderGrid();if(idx<cards.length-1)nextCard();else alert('🎉 Xong! Thuộc '+known.size+'/'+cards.length+' từ');}
function updateProg(){
  const p=cards.length?Math.round(known.size/cards.length*100):0;
  document.getElementById('fcProg').style.width=p+'%';
  document.getElementById('fcProgText').textContent=known.size+'/'+cards.length;
}
function renderGrid(){
  document.getElementById('fcGrid').innerHTML=cards.map((c,i)=>`
    <div class="fc-mini ${known.has(i)?'known':''}" onclick="idx=${i};renderCard()">
      <div style="font-weight:700;margin-bottom:0.2rem;">${c.word}</div>
      <div style="color:var(--muted);font-size:0.76rem;">${known.has(i)?'✓ Đã thuộc':c.meaning}</div>
    </div>`).join('');
}
</script>
</body>
</html>
