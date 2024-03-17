function createPopup(id) {
	let popupNode = document.querySelector(id)
	let overlay = popupNode.querySelector(".overlay")
	let closeBtn = popupNode.querySelector(".close-btn")
	function openPopup() {
		popupNode.classList.add("active")
	}
	function closePopup() {
		popupNode.classList.remove("active")
	}
	overlay.addEventListener("click", closePopup)
	closeBtn.addEventListener("click", closePopup)
	return openPopup
}

let popupMessage = createPopup("#popup-message")
document.querySelector("#open-popup-message-sidebar").addEventListener("click", popupMessage)



