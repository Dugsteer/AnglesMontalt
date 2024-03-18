document.documentElement.scrollTop = 0;

const top1 = document.getElementById("top1");
const top2 = document.getElementById("top2");
const cover = document.getElementById("cover");
const cover1 = document.getElementById("cover1");
const loader = document.getElementById("expander");
const navcontent = document.getElementById("navcontent");
const booky2 = document.querySelector(".navcontent > .booky2text");

const contact = false;

function stopLoader() {
  loader.classList.add("stop");
}

function startLoader() {
  loader.classList.remove("stop");
  setTimeout(stopLoader, 4000);
}

function displayTip() {
  setTimeout(() => (booky2.style.display = "flex"), 100);
}
function displayCancel() {
  booky2.style.display = "none";
}

function openChat() {
      fetch('clearChatHistory.php')
    .then(response => response.text())
    .then(data => {
        console.log("Chat history cleared");
        // You can add any additional logic here to open the chat UI after clearing the history
    })
    .catch(error => console.error('Error clearing chat history:', error));

  // URL of the chat page you want to open
  const chatUrl = "AncientEgyptChat.php";
  // Opening a new window for chat
  window.open(chatUrl, "ChatWindow", "width=400,height=600");
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

navcontent.firstChild.nextElementSibling.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.addEventListener(
  "mouseover",
  displayTip
);
navcontent.firstChild.nextElementSibling.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.addEventListener(
  "mouseout",
  displayCancel
);
