const whose = document.getElementById('whose');
const contact = document.getElementById('contact');
const top1 = document.getElementById('top1');
const cover = document.getElementById('cover');
const cover1 = document.getElementById('cover1');
const loader = document.getElementById("expander");
// const li1 = document.getElementById("li1");
// const li2 = document.getElementById("li2");
// const li3 = document.getElementById("li3");
// const li4 = document.getElementById("li4");
// const li5 = document.getElementById("li5");

function stopLoader() {
    loader.classList.add("stop");
  }

function startLoader(){
    loader.classList.remove("stop");
    setTimeout(stopLoader, 5000);
  }
  
  setTimeout(stopLoader, 5000);



function whoIs (){
    cover1.classList.add('away');
    cover.classList.add('vanish');
top1.innerHTML =       `<div class="piccy">
<div id="cover" class="cover"></div>
<img src="img/DugWebpic.jpg" alt="">
<p><blockquote>"Parlar una altra llengua és tenir una segona ànima"—Carlemany</blockquote></p>
</div>
<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nostrum unde autem repellat eaque maiores quos deleniti minima ad quibusdam consectetur expedita itaque reiciendis aliquid ut voluptas perspiciatis ipsa iusto optio laboriosam, temporibus nihil. Fuga aliquid expedita odit, explicabo quidem qui.
</p>
<div class="booky">
    <img src="img/OlogySeries.jpg" alt="">
    <div id="cover1" class="cover1"></div>
</div>`;
}

function whereIs(){
    cover.classList.add('vanish');
    top1.style.zIndex = "1000";
top1.innerHTML =         ` <div class="left">
<p>Address</p>
<p>form</p>
</div>
<div class="right">
<div class="mapouter"><div class="gmap_canvas"><iframe width="300" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=Angles%20Montalt%2C%20Costa%20Daurada%205&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{position:relative;text-align:right;height:400px;width:400px;}.gmap_canvas {overflow:hidden;background:none!important;height:400px;width:400px;}</style></div>
</div>
<div id="cover" class="cover"></div>
</div>`;

}

whose.addEventListener('click', whoIs);
contact.addEventListener('click', whereIs);


function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}


const expander = document.getElementById('expander');



function goShow(){
    expander.classList.toggle('flexi');
}

