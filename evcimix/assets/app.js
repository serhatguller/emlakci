(function () {
  var favs = [];
  try { favs = JSON.parse(localStorage.getItem('favs') || '[]'); } catch (e) {}
  var count = document.getElementById('favCount');
  function save() { try { localStorage.setItem('favs', JSON.stringify(favs)); } catch (e) {} }
  function paint() {
    if (count) count.textContent = favs.length;
    document.querySelectorAll('[data-fav]').forEach(function (b) {
      b.classList.toggle('on', favs.indexOf(+b.dataset.fav) > -1);
    });
  }
  document.addEventListener('click', function (e) {
    var b = e.target.closest('[data-fav]');
    if (!b) return;
    var id = +b.dataset.fav;
    favs = favs.indexOf(id) > -1 ? favs.filter(function (x) { return x !== id; }) : favs.concat(id);
    save(); paint();
  });
  var fb = document.getElementById('favBtn');
  if (fb) fb.addEventListener('click', function () {
    document.querySelectorAll('.card').forEach(function (c) {
      c.style.display = (!fb.dataset.on || favs.indexOf(+c.dataset.id) > -1) ? '' : 'none';
    });
    fb.dataset.on = fb.dataset.on ? '' : '1';
    if (!fb.dataset.on) document.querySelectorAll('.card').forEach(function (c) { c.style.display = ''; });
  });
  paint();
})();
