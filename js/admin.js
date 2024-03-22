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
	closeBtn.addEventListener("click", function (event) {
		event.preventDefault()
		closePopup()
	})
	return openPopup
}

let popupMessage = createPopup("#popup-message")
document.querySelector("#open-popup-message-sidebar").addEventListener("click", popupMessage)

let editButtons = document.querySelectorAll(".button-management.edit")
editButtons.forEach((button) => {
	let anchorElement = button.closest("tr").querySelector("a")
	if (anchorElement) {
		let topicId = anchorElement.getAttribute("id")
		if (topicId) {
			topicId = topicId.split("-").pop()
			let popupTopic = createPopup(`#popup-topic-${topicId}`)
			button.addEventListener("click", popupTopic)
		} else {
			console.error(
				"Topic ID attribute is missing for anchor element:",
				anchorElement
			)
		}
	} else {
		console.error("Associated anchor tag not found for edit button.")
	}
})



