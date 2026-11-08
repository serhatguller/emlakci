const ilanlar = [
  {id:1,baslik:"Deniz Manzaralı 3+1 Daire",kat:"Konut",durum:"Satılık",sehir:"İstanbul",ilce:"Kadıköy",fiyat:6250000,m2:145,oda:"3+1",img:"photo-1502672260266-1c1ef2d93688"},
  {id:2,baslik:"Bahçeli Müstakil Villa",kat:"Konut",durum:"Satılık",sehir:"İzmir",ilce:"Urla",fiyat:14500000,m2:320,oda:"5+",img:"photo-1564013799919-ab600027ffc6"},
  {id:3,baslik:"Merkezi 2+1 Kiralık Daire",kat:"Konut",durum:"Kiralık",sehir:"Ankara",ilce:"Çankaya",fiyat:28000,m2:95,oda:"2+1",img:"photo-1560448204-e02f11c3d0e2"},
  {id:4,baslik:"İmarlı Yatırımlık Arsa",kat:"Arsa",durum:"Satılık",sehir:"Antalya",ilce:"Kaş",fiyat:3200000,m2:850,oda:"",img:"photo-1500382017468-9049fed747ef"},
  {id:5,baslik:"Lüks Rezidans 1+1",kat:"Konut",durum:"Kiralık",sehir:"İstanbul",ilce:"Şişli",fiyat:45000,m2:70,oda:"1+1",img:"photo-1545324418-cc1a3fa10c00"},
  {id:6,baslik:"Havuzlu Yazlık Villa",kat:"Konut",durum:"Satılık",sehir:"Muğla",ilce:"Bodrum",fiyat:18900000,m2:280,oda:"4+1",img:"photo-1613490493576-7fde63acd811"},
  {id:7,baslik:"Cadde Üstü Dükkan",kat:"İş Yeri",durum:"Kiralık",sehir:"İzmir",ilce:"Alsancak",fiyat:60000,m2:110,oda:"",img:"photo-1441986300917-64674bd600d8"},
  {id:8,baslik:"Komple Satılık 5 Katlı Bina",kat:"Bina",durum:"Satılık",sehir:"Bursa",ilce:"Nilüfer",fiyat:32000000,m2:900,oda:"",img:"photo-1486406146926-c627a92ad1ab"},
  {id:9,baslik:"Site İçi 4+1 Dubleks",kat:"Konut",durum:"Satılık",sehir:"Ankara",ilce:"Çankaya",fiyat:9800000,m2:210,oda:"4+1",img:"photo-1512917774080-9991f1c4c750"}
];
const $ = id => document.getElementById(id);
const tl = n => n.toLocaleString("tr-TR") + " ₺";
let durum = "Satılık", kat = "";
let favs = [];
try { favs = JSON.parse(localStorage.getItem("favs") || "[]"); } catch {}
const saveFavs = () => { try { localStorage.setItem("favs", JSON.stringify(favs)); } catch {} };
let onlyFav = false;

[...new Set(ilanlar.map(i => i.sehir))].sort().forEach(s => $("sehir").add(new Option(s, s)));

const tr = s => s.toLocaleLowerCase("tr");

function filtered() {
  const q = tr($("q").value.trim()), sehir = $("sehir").value, oda = $("oda").value;
  const min = +$("min").value || 0, max = +$("max").value || Infinity, m2 = +$("m2").value || 0;
  let l = ilanlar.filter(i =>
    (!durum || i.durum === durum) && (!kat || i.kat === kat) && (!sehir || i.sehir === sehir) &&
    (!oda || i.oda === oda) && i.fiyat >= min && i.fiyat <= max && i.m2 >= m2 &&
    (!q || tr(`${i.baslik} ${i.sehir} ${i.ilce}`).includes(q)) && (!onlyFav || favs.includes(i.id)));
  const s = $("sort").value;
  if (s === "asc") l.sort((a, b) => a.fiyat - b.fiyat);
  if (s === "desc") l.sort((a, b) => b.fiyat - a.fiyat);
  if (s === "m2") l.sort((a, b) => b.m2 - a.m2);
  return l;
}

function render() {
  const l = filtered();
  $("count").textContent = l.length;
  $("bos").hidden = l.length > 0;
  $("favCount").textContent = favs.length;
  $("list").innerHTML = l.map(i => `
    <article class="card" data-id="${i.id}">
      <img loading="lazy" src="https://images.unsplash.com/${i.img}?w=600" alt="${i.baslik}">
      <div class="info">
        <span class="tag ${i.durum === "Kiralık" ? "k" : ""}">${i.durum} · ${i.kat}</span>
        <h3>${i.baslik}</h3>
        <p class="meta">${i.sehir} / ${i.ilce} · ${i.m2} m²${i.oda ? " · " + i.oda : ""}</p>
        <p class="price">${tl(i.fiyat)}${i.durum === "Kiralık" ? " / ay" : ""}</p>
      </div>
      <button class="fav ${favs.includes(i.id) ? "on" : ""}" data-fav="${i.id}" aria-label="Favori">♥</button>
    </article>`).join("");
}

function tabs(id, cb) {
  $(id).addEventListener("click", e => {
    const b = e.target.closest("button"); if (!b) return;
    $(id).querySelectorAll("button").forEach(x => x.classList.toggle("on", x === b));
    cb(b.dataset.v); render();
  });
}
tabs("durumTabs", v => { durum = v; onlyFav = false; });
tabs("catTabs", v => { kat = v; });

$("list").addEventListener("click", e => {
  const f = e.target.closest("[data-fav]");
  if (f) {
    const id = +f.dataset.fav;
    favs = favs.includes(id) ? favs.filter(x => x !== id) : [...favs, id];
    saveFavs(); render(); return;
  }
  const c = e.target.closest(".card"); if (!c) return;
  const i = ilanlar.find(x => x.id === +c.dataset.id);
  $("modalBody").innerHTML = `<img src="https://images.unsplash.com/${i.img}?w=900" alt="${i.baslik}">
    <div class="in"><span class="tag">${i.durum} · ${i.kat}</span><h2>${i.baslik}</h2>
    <p class="meta">${i.sehir} / ${i.ilce} · ${i.m2} m²${i.oda ? " · " + i.oda : ""}</p>
    <p class="price">${tl(i.fiyat)}${i.durum === "Kiralık" ? " / ay" : ""}</p>
    <a class="btn" style="text-align:center" target="_blank" rel="noopener" href="https://wa.me/902120000000?text=${encodeURIComponent("Merhaba, şu ilan hakkında bilgi almak istiyorum: " + i.baslik)}">WhatsApp ile Ara</a></div>`;
  $("modal").showModal();
});

$("favBtn").addEventListener("click", () => { onlyFav = !onlyFav; render(); });
$("topSearch").addEventListener("submit", e => { e.preventDefault(); render(); });
$("filters").addEventListener("input", render);
$("sort").addEventListener("change", render);
$("reset").addEventListener("click", () => { $("filters").querySelectorAll("input,select").forEach(x => x.value = ""); $("q").value = ""; render(); });
$("contactForm").addEventListener("submit", e => { e.preventDefault(); $("ok").hidden = false; e.target.reset(); });
$("y").textContent = new Date().getFullYear();
render();
