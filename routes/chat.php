<?php
if (!isset($_SESSION['username'])) {
	http_response_code(401); // Unauthorized access
	header('location: ' . $root . '/');
	return;
}

$site['style'][] = '
main {
	min-height: 0; /* Shrink main content to fit parent */
}

.scroll-to-bottom {
	overflow: auto;
	display: flex;
	flex-direction: column-reverse;
}

#chatbox {
	display: flex;
	flex-direction: column;
	height: 100%;
}

#chatbox > #messages {
	overflow-y: scroll;
}

#chatbox > #messages-scroll	 {
	flex-grow: 1;
	padding-right: 1em;
}

#chatbox > #send-message {
	display: flex;
	margin-top: 1em;
}

#chatbox > #send-message > textarea {
	flex-grow: 1;
	min-height: 4em;
	padding: 1em;
	background-color: hsl(0, 0%, 10%);
	color: hsl(0, 0%, 90%);
	border-width: 0;
	margin: 0;
	z-index: 1;
}

#chatbox > #send-message > textarea:focus {
	outline: 1px solid white;
}

#chatbox > #send-message > button > svg {
	height: 2em;
	padding-left: 2em;
	padding-right: 2em;
	fill: hsl(30deg, 20%, 50%);
}

#chatbox > #send-message > button {
	background-color: hsl(0, 0%, 12%);
	cursor: pointer;
	border: 0;
}

#chatbox > #send-message > button:hover {
	background-color: hsl(0, 0%, 15%);
}
'
?>

<template id="template-message">
	<style>
		.message {
			display: flex;
			margin-top: 0.5em;
			border-bottom: solid hsl(30, 20%, 50%,20%) 0.1em;
		}

		.message:hover {
			background-color: hsl(0, 0%, 10%);
		}

		.message>div:not(:last-child) {
			margin-right: 1em;
		}

		.message>.timestamp {
			color: hsl(0, 0%, 50%);
			flex-shrink: 0;
		}

		.action-buttons {
			display: none;
		}

		.message>.content {
			flex-grow: 1;
			word-break: break-word;
		}

		.message>.username {
			text-decoration: underline;
		}

		:host([data-me]) .username {
			color: yellow;
		}

		:host([data-me]) .action-buttons {
			display: block;
		}

		:host([data-me]) .action-buttons > button {
			background-color: hsl(0, 0%, 12%);
			cursor: pointer;
			border: 0;
		}
		:host([data-me]) .action-buttons > button > svg{	
			height: 1em;
			padding-left: 0.5em;
			padding-right: 0.5em;
			fill: hsl(30deg, 20%, 50%);
		}
	</style>
	<div class="message">
		<div class="timestamp">
			<slot name="timestamp" />
		</div>
		<div class="username">
			<slot name="username" />
		</div>
		<div class="content">
			<slot name="content" id="content" />
		</div>
		<div class="action-buttons">
			<button id="edit-button">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
					<!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
					<path d="M373.1 24.97C401.2-3.147 446.8-3.147 474.9 24.97L487 37.09C515.1 65.21 515.1 110.8 487 138.9L289.8 336.2C281.1 344.8 270.4 351.1 258.6 354.5L158.6 383.1C150.2 385.5 141.2 383.1 135 376.1C128.9 370.8 126.5 361.8 128.9 353.4L157.5 253.4C160.9 241.6 167.2 230.9 175.8 222.2L373.1 24.97zM440.1 58.91C431.6 49.54 416.4 49.54 407 58.91L377.9 88L424 134.1L453.1 104.1C462.5 95.6 462.5 80.4 453.1 71.03L440.1 58.91zM203.7 266.6L186.9 325.1L245.4 308.3C249.4 307.2 252.9 305.1 255.8 302.2L390.1 168L344 121.9L209.8 256.2C206.9 259.1 204.8 262.6 203.7 266.6zM200 64C213.3 64 224 74.75 224 88C224 101.3 213.3 112 200 112H88C65.91 112 48 129.9 48 152V424C48 446.1 65.91 464 88 464H360C382.1 464 400 446.1 400 424V312C400 298.7 410.7 288 424 288C437.3 288 448 298.7 448 312V424C448 472.6 408.6 512 360 512H88C39.4 512 0 472.6 0 424V152C0 103.4 39.4 64 88 64H200z" />
				</svg>
			</button>
			<button id="delete-button">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
					<path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
				</svg>
			</button>
		</div>
	</div>
</template>

<div id="chatbox">
	<div class="scroll-to-bottom" id="messages-scroll">
		<div id="messages"></div>
	</div>
	<form id="send-message" method="POST">
		<textarea name="message" required></textarea>
		<button>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
				<!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
				<path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z" />
			</svg>
		</button>
	</form>
</div>

<script type="module">
	const form = document.forms['send-message'];
	const content = form.elements.message;

	content.addEventListener('keyup', (e) => {
		if (e.ctrlKey && e.keyCode === 13) {
			form.requestSubmit();
		}
	});

	const username = '<?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, null, false) ?>';

	form.addEventListener('submit', async (event) => {
		event.preventDefault();

		const {
			value
		} = content;
		content.value = '';

		try {
			const response = await fetch('./api/send.php', {
				method: 'PUT',
				body: value,
			});

			if (!response.ok) {
				const json = await response.json();

				throw new Error(`Unsuccessful: ${response.statusCode} ${json?.error}`);
			}
		} catch (error) {
			alert(error.message);
		}
	});

	const messages = document.getElementById('messages');
	const messagesScroll = document.getElementById('messages-scroll');
	const template = document.getElementById('template-message').content;

	const h = (tag, name, text) => {
		const element = document.createElement(tag);
		element.innerText = text;
		element.slot = name;

		return element;
	};

	customElements.define('chat-message', class extends HTMLElement {
		constructor() {
			super();

			const shadowRoot = this.attachShadow({
				mode: 'open'
			});
			shadowRoot.appendChild(template.cloneNode(true));

			const contentSlot = shadowRoot.getElementById('content');
			const deleteButton = shadowRoot.getElementById('delete-button');
			const editButton = shadowRoot.getElementById('edit-button');

			deleteButton.addEventListener('click', async () => {
				deleteButton.disabled = true;

				try {
					const response = await fetch('./api/deleteMessage.php?id=' + this.getAttribute('id'));

					if (!response.ok) {
						throw new Error(`Failed to delete message - status code ${response.status}`);
					}

					this.remove();
				} catch (error) {
					console.error(error);

					deleteButton.disabled = false;
				}
			});

			editButton.addEventListener('click', async () => {
				editButton.disabled = true;

				try {
					const edited = prompt('Enter edited message: ', contentSlot.assignedElements()[0].innerText);

					if (edited !== null) {
						const response = await fetch('./api/editMessage.php?id=' + this.getAttribute('id'), {
							method: 'PUT',
							body: edited,
						});

						if (!response.ok) {
							throw new Error(`Failed to edit message - status code ${response.status}`);
						}
					}
				} catch (error) {
					console.error(error);
				} finally {
					editButton.disabled = false;
				}
			});
		}
	});

	const addMessages = (array) => {
		const elements = [];

		for (const message of array) {
			const createMessage = () => {
				const messageElement = document.createElement('chat-message');
				messageElement.append(
					h('span', 'timestamp', message.time.slice(0, -4)),
					h('span', 'username', message.username),
					h('span', 'content', message.message),
				);

				messageElement.setAttribute('id', message.id);

				if (message.username === username) {
					messageElement.setAttribute('data-me', '');
				}

				elements.push(messageElement);
			};

			if (message.delete_time) {
				messages.querySelector(`[id="${message.id}"]`)?.remove();
			} else if (message.edit_time) {
				const existingMessage = messages.querySelector(`[id="${message.id}"] > span[slot="content"]`);

				if (existingMessage) {
					existingMessage.innerText = message.message;
				} else {
					createMessage();
				}
			} else {
				createMessage();
			}
		}

		messages.append(...elements);
	};

	try {
		const historyResponse = await fetch('./api/history.php');
		const history = await historyResponse.json();
		addMessages(history);
	} catch (error) {
		console.error(error);
	}

	let updateTimeout;
	const update = async () => {
		try {
			const url = new URL('./api/history.php', location.href);
			url.searchParams.set('sync', '1');

			const historyUpdateResponse = await fetch(url);

			if (!historyUpdateResponse.ok) {
				throw new Error(`History Update Error - ${historyUpdateResponse.status}`);
			}

			const historyUpdate = await historyUpdateResponse.json();

			const {
				scrollTop
			} = messagesScroll; // const scrollTop = messagesScroll.scrollTop;

			addMessages(historyUpdate);

			if (historyUpdate.length !== 0 && scrollTop > -1) {
				messagesScroll.scrollTo(0, messagesScroll.scrollHeight); // Scroll to bottom
			}
		} catch (error) {
			console.error(error);
		}

		setTimeout(update, 1000);
	};
	update();
</script>