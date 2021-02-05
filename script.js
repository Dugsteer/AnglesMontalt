document.documentElement.scrollTop = 0;

const top1 = document.getElementById("top1");
const top2 = document.getElementById("top2");
const cover = document.getElementById("cover");
const cover1 = document.getElementById("cover1");
const loader = document.getElementById("expander");
const navcontent = document.getElementById("navcontent");
const contact = false;

function stopLoader() {
  loader.classList.add("stop");
}

function startLoader() {
  loader.classList.remove("stop");
  setTimeout(stopLoader, 4000);
}

setTimeout(stopLoader, 4000);

function whoIs() {
  top2.classList.remove("left");
  top2.classList.remove("right");
  top2.classList.add("middle");
  top1.classList.add("right");
}
function inTouch() {
  top1.classList.remove("left");
  top1.classList.remove("right");
  top1.classList.add("middle");
  top2.classList.add("right");
}

const expander = document.getElementById("expander");

document.querySelectorAll(".fa-eye").forEach((eye) => {
  eye.addEventListener("click", () => {
    if (contact === false) {
      inTouch();
      navcontent.scrollIntoView();
      contact === true;
    } else {
      window.location.reload();
    }
  });
});
